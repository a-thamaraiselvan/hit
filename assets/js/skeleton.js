/* Common skeleton image loader
   Usage: add class `skeleton-img` and attribute `data-src="/path/to/image.jpg"` to <img>
   Optionally wrap with a container or add `lab-thumb` / `skeleton-square` classes to the wrapper.
*/
(function(){
  const PLACEHOLDER_SVG = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="4" height="3" viewBox="0 0 4 3"></svg>';

  function createWrapper(img){
    if(img.parentElement && img.parentElement.classList && img.parentElement.classList.contains('skeleton-wrapper')){
      return img.parentElement;
    }
    const wrapper = document.createElement('span');
    wrapper.className = 'skeleton-wrapper';
    // carry over helper classes if present on image (e.g., lab-thumb)
    if(img.dataset.wrapperClass){ wrapper.classList.add(...img.dataset.wrapperClass.split(' ')); }
    img.parentNode.insertBefore(wrapper, img);
    wrapper.appendChild(img);
    return wrapper;
  }

  function loadImage(img, wrapper){
    const src = img.dataset.src;
    if(!src) return;
    img.addEventListener('load', function onLoad(){
      wrapper.classList.add('loaded');
      img.removeEventListener('load', onLoad);
    });
    img.addEventListener('error', function(){
      wrapper.classList.add('error');
    });
    // start loading
    img.src = src;
  }

  function init(){
    const images = Array.from(document.querySelectorAll('img.skeleton-img'));
    if(images.length===0) return;

    const supportsObserver = 'IntersectionObserver' in window;
    if(supportsObserver){
      const io = new IntersectionObserver((entries)=>{
        entries.forEach(entry=>{
          if(entry.isIntersecting){
            const img = entry.target;
            const wrapper = createWrapper(img);
            loadImage(img, wrapper);
            io.unobserve(img);
          }
        });
      },{rootMargin:'200px'});

      images.forEach(img=>{
        // ensure placeholder to avoid network request to empty src
        if(!img.getAttribute('src')) img.src = PLACEHOLDER_SVG;
        io.observe(img);
      });
    } else {
      // fallback: load all immediately after DOM ready
      images.forEach(img=>{
        const wrapper = createWrapper(img);
        if(!img.getAttribute('src')) img.src = PLACEHOLDER_SVG;
        loadImage(img, wrapper);
      });
    }
  }

  if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded', init);
  } else init();

})();
