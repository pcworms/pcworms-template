<div id="loader-overlay">
    <div class="loader-container">
        <div id="loader"></div>
    </div>
</div>

<script>
    // window.addEventListener("pageshow",()=>{
    //     document.getElementById('loader-overlay').style.display="none";
    // })
    if (!(history.state && history.state.loader === false)){
        document.body.style.overflow="hidden";
        document.getElementById('loader-overlay').style.display="block";
        const animation = bodymovin.loadAnimation({
            container: document.getElementById('loader'), // required
            path: '<?php echo get_stylesheet_directory_uri() . '/assets/loader-animation/data.json' ?>', // required
            renderer: 'svg', // required
            loop: false, // optional
            autoplay: true, // optional
            name: "Loader Animation", // optional
        });
        function wait(ms){
            return new Promise(r=> {setTimeout(r, ms);})
        }
        const prom = wait(2000)
        window.addEventListener('load', () => {
            prom.then(r=>{
                document.getElementById('loader-overlay').style.opacity = "0";
                wait(1000).then(res=>{
                    document.getElementById('loader-overlay').style.display="none";
                    document.body.style.overflow="auto";
                });
            });
        });
    } else {}
    history.pushState({loader:false},"","")
    addEventListener("popstate",()=>{history.back()})
</script>