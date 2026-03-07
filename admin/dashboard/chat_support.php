<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

// Function to get data from any table
function getTableData($conn, $table, $condition = '', $limit = 10)
{
    try {
        $sql = "SELECT * FROM " . $table;
        if ($condition) {
            $sql .= " WHERE " . $condition;
        }
        $sql .= " ORDER BY created_at DESC LIMIT " . $limit;
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return ["error" => $e->getMessage()];
    }
}

// Function to process chat queries
function processChatQuery($conn, $query)
{
    $query = strtolower($query);

    // Log the query for future training
    logChatQuery($conn, $query);

    // Check for greetings
    if (preg_match('/(hello|hi|hey|greetings|good morning|good afternoon|good evening)/', $query)) {
        return [
            'type' => 'greeting',
            'message' => "Hello! I'm your Hindusthan College admin assistant. How can I help you today?"
        ];
    }

    // Check for thank you messages
    if (preg_match('/(thank you|thanks|thx|thank)/', $query)) {
        return [
            'type' => 'thanks',
            'message' => "You're welcome! Is there anything else I can help you with?"
        ];
    }

    // Check for goodbye messages
    if (preg_match('/(bye|goodbye|see you|farewell)/', $query)) {
        return [
            'type' => 'goodbye',
            'message' => "Goodbye! Feel free to chat again if you need any assistance."
        ];
    }

    // Enquiries related queries
    if (strpos($query, 'enquiry') !== false || strpos($query, 'enquiries') !== false || strpos($query, 'inquiry') !== false) {
        $date_condition = extractDateCondition($query);
        $data = getTableData($conn, 'enquiries', $date_condition);

        // Check for specific enquiry types
        $type_condition = '';
        if (strpos($query, 'admission') !== false) {
            $type_condition = "subject LIKE '%admission%'";
        } elseif (strpos($query, 'scholarship') !== false) {
            $type_condition = "subject LIKE '%scholarship%'";
        } elseif (strpos($query, 'hostel') !== false) {
            $type_condition = "subject LIKE '%hostel%' OR message LIKE '%hostel%'";
        }

        if ($type_condition) {
            $data = getTableData($conn, 'enquiries', $type_condition);
        }

        return [
            'type' => 'enquiries',
            'date_condition' => $date_condition,
            'count' => count($data),
            'data' => $data
        ];
    }

    // Alumni related queries
    if (strpos($query, 'alumni') !== false) {
        $condition = '';

        // Check for year specific queries
        if (preg_match('/year (\d{4})/', $query, $matches)) {
            $condition = "graduation_year = '" . $matches[1] . "'";
        }
        // Check for course specific queries
        elseif (preg_match('/course ([\w\s]+)/', $query, $matches)) {
            $condition = "course LIKE '%" . $matches[1] . "%'";
        }
        // Check for company specific queries
        elseif (preg_match('/(company|working at|employed at|job at) ([\w\s]+)/', $query, $matches)) {
            $condition = "company LIKE '%" . $matches[2] . "%'";
        }
        // Check for position specific queries
        elseif (preg_match('/(position|role|job|working as) ([\w\s]+)/', $query, $matches)) {
            $condition = "current_position LIKE '%" . $matches[2] . "%'";
        }

        $data = getTableData($conn, 'alumni', $condition);
        return [
            'type' => 'alumni',
            'count' => count($data),
            'data' => $data
        ];
    }

    // News/Events related queries
    if (strpos($query, 'news') !== false || strpos($query, 'event') !== false) {
        $condition = '';

        // Check for special events
        if (strpos($query, 'special') !== false) {
            $condition = "is_special = 1";
        }
        // Check for date specific queries
        elseif (preg_match('/(\d{2}[-\/]\d{2}[-\/]\d{4})/', $query, $matches)) {
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $matches[1])));
            $condition = "event_date = '$date'";
        }
        // Check for venue specific queries
        elseif (preg_match('/(venue|location|place) ([\w\s]+)/', $query, $matches)) {
            $condition = "venue LIKE '%" . $matches[2] . "%'";
        }
        // Check for chief guest specific queries
        elseif (preg_match('/(chief guest|guest|speaker) ([\w\s]+)/', $query, $matches)) {
            $condition = "chief_guest LIKE '%" . $matches[2] . "%'";
        }

        $data = getTableData($conn, 'news_events', $condition);
        return [
            'type' => 'news_events',
            'count' => count($data),
            'data' => $data
        ];
    }

    // Admin users related queries
    if (strpos($query, 'admin') !== false || strpos($query, 'user') !== false) {
        $condition = '';

        // Check for active/inactive status
        if (strpos($query, 'active') !== false) {
            $condition = "status = 'active'";
        } elseif (strpos($query, 'inactive') !== false) {
            $condition = "status = 'inactive'";
        }

        $data = getTableData($conn, 'admin_users', $condition);
        return [
            'type' => 'admin_users',
            'count' => count($data),
            'data' => $data
        ];
    }

    // Statistics and summary queries
    if (strpos($query, 'statistic') !== false || strpos($query, 'summary') !== false || strpos($query, 'overview') !== false || strpos($query, 'dashboard') !== false) {
        // Get counts from different tables
        $enquiries_count = countRecords($conn, 'enquiries');
        $alumni_count = countRecords($conn, 'alumni');
        $news_count = countRecords($conn, 'news_events');
        $users_count = countRecords($conn, 'admin_users');

        return [
            'type' => 'statistics',
            'message' => "Here's a summary of your data:\n\n" .
                "- Total Enquiries: $enquiries_count\n" .
                "- Total Alumni Records: $alumni_count\n" .
                "- Total News/Events: $news_count\n" .
                "- Total Admin Users: $users_count",
            'data' => [
                'enquiries' => $enquiries_count,
                'alumni' => $alumni_count,
                'news' => $news_count,
                'users' => $users_count
            ]
        ];
    }

    // Course related queries
    if (strpos($query, 'course') !== false || strpos($query, 'program') !== false || strpos($query, 'degree') !== false) {
        return [
            'type' => 'courses',
            'message' => "We offer various undergraduate and postgraduate programs including:\n\n" .
                "- B.Tech in Computer Science, Mechanical, Civil, and Electrical Engineering\n" .
                "- BBA, BCA, B.Com, and BA programs\n" .
                "- MBA with various specializations\n" .
                "- M.Tech programs\n" .
                "- Ph.D. programs in multiple disciplines"
        ];
    }

    // Admission related queries
    if (strpos($query, 'admission') !== false || strpos($query, 'apply') !== false || strpos($query, 'application') !== false) {
        return [
            'type' => 'admission',
            'message' => "Our admission process includes:\n\n" .
                "- Online application submission\n" .
                "- Entrance examination (for specific programs)\n" .
                "- Document verification\n" .
                "- Interview (for postgraduate programs)\n" .
                "- Fee payment and enrollment"
        ];
    }

    // Fees related queries
    if (strpos($query, 'fee') !== false || strpos($query, 'tuition') !== false || strpos($query, 'payment') !== false) {
        return [
            'type' => 'fees',
            'message' => "Our fee structure varies by program:\n\n" .
                "- Undergraduate programs: ₹80,000 - ₹1,50,000 per year\n" .
                "- Postgraduate programs: ₹90,000 - ₹2,00,000 per year\n" .
                "- Ph.D. programs: ₹1,00,000 - ₹1,50,000 per year\n\n" .
                "We also offer scholarships based on merit and need."
        ];
    }

    // Scholarship related queries
    if (strpos($query, 'scholarship') !== false || strpos($query, 'financial aid') !== false || strpos($query, 'discount') !== false) {
        return [
            'type' => 'scholarship',
            'message' => "We offer various scholarships:\n\n" .
                "- Merit-based scholarships (up to 50% tuition waiver)\n" .
                "- Sports scholarships\n" .
                "- Need-based financial aid\n" .
                "- Special scholarships for women in engineering\n" .
                "- Research scholarships for postgraduate students"
        ];
    }

    // Placement related queries
    if (strpos($query, 'placement') !== false || strpos($query, 'job') !== false || strpos($query, 'career') !== false || strpos($query, 'recruit') !== false) {
        return [
            'type' => 'placement',
            'message' => "Our placement highlights:\n\n" .
                "- 90% placement rate for eligible students\n" .
                "- Top recruiters include TCS, Wipro, Infosys, Amazon, and more\n" .
                "- Average package: ₹2.5 LPA\n" .
                "- Highest package: ₹44 LPA\n" .
                "- Pre-placement training and career counseling available"
        ];
    }

    // Faculty related queries
    if (strpos($query, 'faculty') !== false || strpos($query, 'professor') !== false || strpos($query, 'teacher') !== false || strpos($query, 'staff') !== false) {
        return [
            'type' => 'faculty',
            'message' => "Our faculty information:\n\n" .
                "- Total teaching staff: 1000+\n" .
                "- Total non-teaching staff: 500+\n" .
                "- Faculty with Ph.D.: 60%\n" .
                "- Faculty with industry experience: 75%\n" .
                "- Student-faculty ratio: 15:1"
        ];
    }

    // Campus related queries
    if (strpos($query, 'campus') !== false || strpos($query, 'facility') !== false || strpos($query, 'infrastructure') !== false) {
        return [
            'type' => 'campus',
            'message' => "Our campus features:\n\n" .
                "- 6 campuses hosting 11 institutions in Coimbatore\n" .
                "- State-of-the-art laboratories and research centers\n" .
                "- Modern libraries with extensive collections\n" .
                "- Sports facilities including indoor and outdoor courts\n" .
                "- Hostels with comfortable accommodation\n" .
                "- Wi-Fi enabled campus"
        ];
    }

    // Hostel related queries
    if (strpos($query, 'hostel') !== false || strpos($query, 'accommodation') !== false || strpos($query, 'dormitory') !== false) {
        return [
            'type' => 'hostel',
            'message' => "Our hostel facilities:\n\n" .
                "- Separate hostels for boys and girls\n" .
                "- AC and non-AC rooms available\n" .
                "- 24/7 security and surveillance\n" .
                "- Mess with nutritious meals\n" .
                "- Recreation rooms and common areas\n" .
                "- Laundry services"
        ];
    }

    // Default response for unrecognized queries
    return [
        'type' => 'help',
        'message' => "I can help you with information about:\n        
1. Enquiries:
   - \"Show today's enquiries\"\n   - \"How many enquiries on DD/MM/YYYY?\"\n   - \"Show admission enquiries\"\n   - \"Show scholarship enquiries\"\n
2. Alumni:
   - \"Show alumni from year 2020\"\n   - \"List alumni from CSE course\"\n   - \"Show alumni working at TCS\"\n   - \"Show alumni in software developer role\"\n
3. News & Events:
   - \"Show special events\"\n   - \"List events on DD/MM/YYYY\"\n   - \"Show events at Main Auditorium\"\n   - \"Show events with chief guest Dr. Smith\"\n
4. Admin Users:
   - \"Show active admin users\"\n   - \"List all admin users\"\n   - \"Show inactive admins\"\n
5. Statistics:
   - \"Show dashboard summary\"\n   - \"Give me statistics overview\"\n
6. Other Information:
   - Courses, Admissions, Fees, Scholarships\n   - Placements, Faculty, Campus, Hostels"
    ];
}

// Function to log chat queries for future training
function logChatQuery($conn, $query)
{
    try {
        // Create table if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS admin_chat_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            query TEXT NOT NULL,
            timestamp DATETIME NOT NULL
        )");

        // Insert the query
        $stmt = $conn->prepare("INSERT INTO admin_chat_logs (query, timestamp) VALUES (?, NOW())");
        $stmt->execute([$query]);
    } catch (PDOException $e) {
        // Silently handle error
    }
}

// Function to count records in a table
function countRecords($conn, $table, $condition = '')
{
    try {
        $sql = "SELECT COUNT(*) FROM " . $table;
        if ($condition) {
            $sql .= " WHERE " . $condition;
        }
        $stmt = $conn->query($sql);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

function extractDateCondition($query)
{
    // Check for specific date
    if (preg_match('/(\d{2}[-\/]\d{2}[-\/]\d{4})/', $query, $matches)) {
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $matches[1])));
        return "DATE(created_at) = '$date'";
    }
    // Check for relative dates
    elseif (preg_match('/today|yesterday|tomorrow/', $query, $matches)) {
        switch ($matches[0]) {
            case 'yesterday':
                return "DATE(created_at) = DATE(NOW() - INTERVAL 1 DAY)";
            case 'tomorrow':
                return "DATE(created_at) = DATE(NOW() + INTERVAL 1 DAY)";
            default:
                return "DATE(created_at) = CURRENT_DATE()";
        }
    }
    // Check for date ranges
    elseif (strpos($query, 'last') !== false) {
        if (strpos($query, 'week') !== false) {
            return "created_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
        } elseif (strpos($query, 'month') !== false) {
            return "created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        } elseif (strpos($query, 'year') !== false) {
            return "created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
        } elseif (preg_match('/last (\d+) days?/', $query, $matches)) {
            $days = $matches[1];
            return "created_at >= DATE_SUB(NOW(), INTERVAL $days DAY)";
        }
    }
    // Check for this week/month/year
    elseif (strpos($query, 'this') !== false) {
        if (strpos($query, 'week') !== false) {
            return "YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
        } elseif (strpos($query, 'month') !== false) {
            return "YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at) = MONTH(CURRENT_DATE())";
        } elseif (strpos($query, 'year') !== false) {
            return "YEAR(created_at) = YEAR(CURRENT_DATE())";
        }
    }
    return '';
}

// Handle chat query submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $response = processChatQuery($conn, $_POST['query']);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

ob_start();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Advanced Chat Support System</h3>
                </div>
                <div class="card-body">
                    <div id="chat-messages" class="mb-4" style="height: 300px; overflow-y: auto;">
                        <!-- Chat messages will appear here -->
                    </div>
                    <form id="chat-form">
                        <div class="input-group">
                            <input type="text" class="form-control" id="chat-input"
                                placeholder="Ask me anything about the college data...">
                            <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Show welcome message when page loads
        setTimeout(function () {
            addMessage('bot', 'Hello! I\'m your Hindusthan College admin assistant. How can I help you today?');
        }, 500);

        document.getElementById('chat-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const input = document.getElementById('chat-input');
            const query = input.value.trim();
            if (!query) return;

            addMessage('user', query);

            // Show typing indicator
            showTypingIndicator();

            fetch('chat_support.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'query=' + encodeURIComponent(query)
            })
                .then(response => response.json())
                .then(data => {
                    // Hide typing indicator
                    hideTypingIndicator();

                    let responseMessage = '';

                    switch (data.type) {
                        case 'enquiries':
                            responseMessage = formatEnquiriesResponse(data);
                            break;
                        case 'alumni':
                            responseMessage = formatAlumniResponse(data);
                            break;
                        case 'news_events':
                            responseMessage = formatNewsEventsResponse(data);
                            break;
                        case 'admin_users':
                            responseMessage = formatAdminUsersResponse(data);
                            break;
                        case 'statistics':
                        case 'courses':
                        case 'admission':
                        case 'fees':
                        case 'scholarship':
                        case 'placement':
                        case 'faculty':
                        case 'campus':
                        case 'hostel':
                        case 'greeting':
                        case 'thanks':
                        case 'goodbye':
                            responseMessage = data.message;
                            break;
                        default:
                            responseMessage = data.message;
                    }

                    addMessage('bot', responseMessage);

                    // Suggest follow-up questions based on the current query
                    suggestFollowUpQuestions(data.type);
                })
                .catch(error => {
                    // Hide typing indicator
                    hideTypingIndicator();
                    addMessage('bot', 'Sorry, there was an error processing your request.');
                });

            input.value = '';
        });

        function formatEnquiriesResponse(data) {
            let response = `Found ${data.count} enquiries`;
            if (data.date_condition) {
                response += ` for the specified period`;
            }
            response += ':\n\n';

            if (data.count > 0) {
                data.data.forEach(enquiry => {
                    response += `- ${enquiry.name} (${enquiry.email})\n`;
                    response += `  Subject: ${enquiry.subject}\n`;
                    response += `  Date: ${new Date(enquiry.created_at).toLocaleDateString()}\n\n`;
                });
            } else {
                response += 'No enquiries found for the specified criteria.';
            }
            return response;
        }

        function formatAlumniResponse(data) {
            let response = `Found ${data.count} alumni records:\n\n`;

            if (data.count > 0) {
                data.data.forEach(alumni => {
                    response += `- ${alumni.name}\n`;
                    response += `  Course: ${alumni.course} (${alumni.graduation_year})\n`;
                    response += `  Current: ${alumni.current_position} at ${alumni.company}\n`;
                    if (alumni.linkedin_url) {
                        response += `  LinkedIn: ${alumni.linkedin_url}\n`;
                    }
                    response += '\n';
                });
            } else {
                response += 'No alumni records found for the specified criteria.';
            }
            return response;
        }

        function formatNewsEventsResponse(data) {
            let response = `Found ${data.count} news/events:\n\n`;

            if (data.count > 0) {
                data.data.forEach(event => {
                    response += `- ${event.title}\n`;
                    response += `  Event: ${event.event_name}\n`;
                    response += `  Date: ${event.event_date}\n`;
                    response += `  Venue: ${event.venue}\n`;
                    if (event.chief_guest) {
                        response += `  Chief Guest: ${event.chief_guest}\n`;
                    }
                    response += '\n';
                });
            } else {
                response += 'No news/events found for the specified criteria.';
            }
            return response;
        }

        function formatAdminUsersResponse(data) {
            let response = `Found ${data.count} admin users:\n\n`;

            if (data.count > 0) {
                data.data.forEach(user => {
                    response += `- ${user.username}\n`;
                    response += `  Email: ${user.email}\n`;
                    response += `  Status: ${user.status}\n`;
                    response += `  Created: ${new Date(user.created_at).toLocaleDateString()}\n\n`;
                });
            } else {
                response += 'No admin users found for the specified criteria.';
            }
            return response;
        }

        function suggestFollowUpQuestions(type) {
            let suggestions = [];

            switch (type) {
                case 'enquiries':
                    suggestions = [
                        'Show admission enquiries',
                        'How many enquiries in the last week?',
                        'Show scholarship enquiries'
                    ];
                    break;
                case 'alumni':
                    suggestions = [
                        'Show alumni from CSE course',
                        'Show alumni working at TCS',
                        'Show alumni from year 2022'
                    ];
                    break;
                case 'news_events':
                    suggestions = [
                        'Show special events',
                        'Show events this month',
                        'Show recent news'
                    ];
                    break;
                case 'admin_users':
                    suggestions = [
                        'Show active admin users',
                        'Show inactive admins',
                        'How many admin users are there?'
                    ];
                    break;
                case 'statistics':
                    suggestions = [
                        'Tell me about admissions',
                        'Show alumni statistics',
                        'Tell me about placements'
                    ];
                    break;
                default:
                    suggestions = [
                        'Show today\'s enquiries',
                        'Tell me about placements',
                        'Show dashboard summary'
                    ];
            }

            // Add suggestions to chat
            setTimeout(function () {
                addSuggestions(suggestions);
            }, 1000);
        }

        function addSuggestions(suggestions) {
            const messagesDiv = document.getElementById('chat-messages');
            const suggestionsDiv = document.createElement('div');
            suggestionsDiv.className = 'suggestions mb-3';
            suggestionsDiv.innerHTML = '<div class="suggestion-label">Suggested questions:</div>';

            const buttonsDiv = document.createElement('div');
            buttonsDiv.className = 'suggestion-buttons';

            suggestions.forEach(suggestion => {
                const button = document.createElement('button');
                button.className = 'btn btn-sm btn-outline-primary suggestion-btn';
                button.textContent = suggestion;
                button.addEventListener('click', function () {
                    document.getElementById('chat-input').value = suggestion;
                    document.getElementById('chat-form').dispatchEvent(new Event('submit'));
                });
                buttonsDiv.appendChild(button);
            });

            suggestionsDiv.appendChild(buttonsDiv);
            messagesDiv.appendChild(suggestionsDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function addMessage(type, message) {
            const messagesDiv = document.getElementById('chat-messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${type}-message mb-3`;
            messageDiv.innerHTML = `
            <div class="card ${type === 'user' ? 'bg-light float-end' : 'bg-primary text-white float-start'}" style="max-width: 70%;">
                <div class="card-body py-2 px-3">
                    <p class="mb-0">${message.replace(/\n/g, '<br>')}</p>
                </div>
            </div>
            <div class="clearfix"></div>
        `;
            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function showTypingIndicator() {
            const messagesDiv = document.getElementById('chat-messages');
            const typingDiv = document.createElement('div');
            typingDiv.className = 'typing-indicator';
            typingDiv.id = 'typing-indicator';

            typingDiv.innerHTML = `
            <div class="card bg-primary text-white float-start" style="max-width: 70%;">
                <div class="card-body py-2 px-3">
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        `;

            messagesDiv.appendChild(typingDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function hideTypingIndicator() {
            const typingIndicator = document.getElementById('typing-indicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }
    });
</script>

<style>
    .chat-message {
        margin-bottom: 15px;
    }

    p {
        color: black !important;
    }

    .user-message .card {
        background-color: white !important;
        color: black !important;
    }

    .bot-message .card {
        background-color: #ed6f26 !important;
        color: black !important
    }

    .typing-dots {
        display: flex;
    }

    .typing-dots span {
        height: 8px;
        width: 8px;
        background-color: #fff;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        animation: typing 1s infinite ease-in-out;
    }

    .typing-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-dots span:nth-child(3) {
        animation-delay: 0.4s;
        margin-right: 0;
    }

    @keyframes typing {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-5px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .suggestions {
        margin-left: 15px;
    }

    .suggestion-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }

    .suggestion-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .suggestion-btn {
        margin-bottom: 5px;
        font-size: 12px;
        white-space: normal;
        text-align: left;
    }
</style>

<?php
$content = ob_get_clean();
require_once '../includes/layout.php';
?>