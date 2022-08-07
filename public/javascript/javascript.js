

    window.onload = function(){

        loadRSS();

    }


    function loadRSS(){

        setLoadingMessage()
        const xhr = new XMLHttpRequest();

        let sortOrder = document.getElementById('sort-order');
        let sortField = document.getElementById('sort-field');

        xhr.open('GET', '/ajax/getfeed/' + sortOrder.options[sortOrder.selectedIndex].value + '/' + sortField.options[sortField.selectedIndex].value , true);

        xhr.timeout = 6000; 

        xhr.onload = function () {

            let response;
            try {
                response = JSON.parse(xhr.responseText);

            } catch (e) {
                setErrorMessage('Noe er galt med tjenesten, vennligst forsøk igjen senere');
                return;
            }

            if(response && response.success && response.data.errorcode == 0){
                showFeed(response.data.feed);
            }else{
                setErrorMessage('Noe er galt med tjenesten, vennligst forsøk igjen senere');
            }
        };

        xhr.ontimeout = function (e) {
            setErrorMessage('Tjenesten tok for lang tid å respondere, så ingenting kan vises');
        };

        xhr.onerror = function(error){
            setErrorMessage('Noe er galt med tjenesten, vennligst forsøk igjen senere');
        }

        xhr.send(null);

    }

    function setLoadingMessage(){
        let element = document.getElementById('content-field');
        element.classList.remove('display-urix');
        element.classList.add('loading-urix');

        element.innerHTML = "Laster rss for urix";
        
    }
    
    function setErrorMessage(errorText){
        let element = document.getElementById('content-field');
        element.classList.remove('display-urix');
        element.classList.add('loading-urix');

        element.innerHTML = errorText;
        
    }


    function showFeed(feed){

        let element = document.getElementById('content-field');
        element.classList.remove('loading-urix');
        element.classList.add('display-urix');

        let stringFeed = "";
        feed.forEach(function(value, index, array){
            stringFeed += "<div class='feed-item'>";
            if(value.media_content && value.media_content.url){
                stringFeed += "<div class='feed-section'>";
                stringFeed += "<img style='max-width:500px;' src='" + value.media_content.url + "' />";
                stringFeed += "</div>";
            }
            stringFeed += "<div>";
            stringFeed += "<b>" + value.title + "</b><br /> ";
            stringFeed += "<p>" + value.description + "<br /><a href='" + value.link + "' target='_blank'>les mer</a></p> ";
            stringFeed += "<i>" + value.pubDate + "</i><br /><br /> ";
            stringFeed += "</div>";
        });
        
         element.innerHTML = stringFeed;
    }