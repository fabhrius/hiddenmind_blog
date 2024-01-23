<?php

class FlipBookCreator {

    function getBookString($arrayImagePaths, $bookTitle, $endString, $bookHtml_id){ // , $coverSupPath, $coverInfPath

      $bookString = '' .
      //$this->addNavigationButtonsPanel() . 
      $this->addCoverSup($bookTitle, $bookHtml_id) .  // , $coverSupPath
      $this->addPages($arrayImagePaths) .
      $this->addCoverInf($endString) . // , $coverInfPath
      $this->addJavaScriptLibrary() .
      $this->addBookConfiguration($bookHtml_id) .
      $this->addJavaScriptFunctionality() .
      "";    

      return $bookString;
    }

    function addNavigationButtonsPanel(){
      $codeString = '
      <div class="wrapper">    
        <div class="container">
            <h1>Title and Chapter Here ---------------------------------------------------</h1>
            <div>
                <button type="button" class="btn-prev btn btn-primary">Previous page</button>
                <span class="page-current">1</span> of <span class="page-total">-</span>
                <button type="button" class="btn-next btn btn-primary">Next page</button>
            </div>   
            <div class="alert alert-danger mt-3 mb-3">
                State: <i class="page-state">read</i>, orientation: <i class="page-orientation">landscape</i>
            </div> 
        </div>
      ';

      return $codeString;
    }

    function addCoverSup($bookTitle, $bookHtml_id){ // , $coverSupPath
      $codeString = '
      <div class="container">
          <div class="flip-book" id="' . $bookHtml_id . '">
              <div class="page page-cover page-cover-top" data-density="hard">
                  <div class="page-content">
                      <h2>' . $bookTitle . '</h2>
                  </div>
              </div>        
              <div class="page page-cover">
                  <div class="page-content">
                  </div>
              </div>
      ';
      return $codeString;
    }

    function addCoverInf($endString){ // , $coverInfPath
      $codeString = '
            <div class="page page-cover page-cover-bottom" data-density="hard">
                <div class="page-content">
                    <h2>' . $endString . '</h2>
                </div>
            </div>
        </div>
      </div>
      </div>
      ';

      return $codeString;
    }

    function addJavaScriptLibrary(){
      $codeString = '
      <script src="https://cdn.jsdelivr.net/npm/page-flip@0.4.3/dist/js/page-flip.browser.min.js"></script>
      ';

      return $codeString;
    }

    function addBookConfiguration($bookHtml_id){
      $codeString = '
        <script>
          document.addEventListener(\'DOMContentLoaded\', function() {

            const pageFlip = new St.PageFlip(
                document.getElementById("' . $bookHtml_id . '"),
                {
                    width: 817, //550, // base page width
                    height: 1057, //733, // base page height

                    size: "stretch",
                    // set threshold values:
                    minWidth: 315,
                    maxWidth: 1000,
                    minHeight: 420,
                    maxHeight: 1350,

                    maxShadowOpacity: 0.5, // Half shadow intensity
                    showCover: true,
                    mobileScrollSupport: false // disable content scrolling on mobile devices
                }
            );

            // load pages
            pageFlip.loadFromHTML(document.querySelectorAll(".page"));

        ';

      return $codeString;
    }

    function addJavaScriptFunctionality(){
      $codeString = '
 
          document.querySelector(".page-total").innerText = pageFlip.getPageCount();
          document.querySelector(
              ".page-orientation"
          ).innerText = pageFlip.getOrientation();
      
          document.querySelector(".btn-prev").addEventListener("click", () => {
              pageFlip.flipPrev(); // Turn to the previous page (with animation)
          });
      
          document.querySelector(".btn-next").addEventListener("click", () => {
              pageFlip.flipNext(); // Turn to the next page (with animation)
          });
      
          // triggered by page turning
          pageFlip.on("flip", (e) => {
              document.querySelector(".page-current").innerText = e.data + 1;
          });
      
          // triggered when the state of the book changes
          pageFlip.on("changeState", (e) => {
              document.querySelector(".page-state").innerText = e.data;
          });
      
          // triggered when page orientation changes
          pageFlip.on("changeOrientation", (e) => {
              document.querySelector(".page-orientation").innerText = e.data;
          });
        });
        </script>    
      ';

      return $codeString;
    }

    function addPages($arrayImagePaths){
      $codeString = '';
      foreach($arrayImagePaths as $key => $value){
        $codeString .= $this->addPage($value);
      }
      return $codeString;
    }

    function addPage($imagePath){
      $codeString = '
      <div class="page">
          <div class="page-content">
              <!-- <h2 class="page-header">Page header 1</h2> -->
              <div class="page-image" style="background-image: url(' . $imagePath . ')"></div>
              <!--  <div class="page-footer">2</div> -->
          </div>
      </div>
      ';

      return $codeString;
    }

  }



?>