$(document).scroll(function(){
    
    var isScrolled = $(this).scrollTop() >   $(".topBar").height();
    $(".topBar").toggleClass("scrolled", isScrolled  );
} )

function volumeToggle(button) {
  var muted = $(".previewVideo").prop("muted");
  $(".previewVideo").prop("muted", !muted);

  $(button).find("i").toggleClass("fa-volume-mute");
  $(button).find("i").toggleClass("fa-volume-up");
}

function previewEnded() {
  $(".previewVideo").toggle();
  $(".previewImage").toggle();
}

function goBack() {
  window.history.back();
}

function startHideTimer() {
  var timeout = null;
  
  $(document).on("mousemove", function() {
      clearTimeout(timeout);
      $(".watchNav").fadeIn();

      timeout = setTimeout(function() {
          $(".watchNav").fadeOut();
      }, 2000);
  })
}

function initVideo(videoId, username) {
  startHideTimer();
  setStartTime(videoId, username);
  updateProgressTimer(videoId, username);
}

function updateProgressTimer(videoId, username) {
  addDuration(videoId, username);

  var timer;

  $("video").on("playing", function(event) {
      window.clearInterval(timer);
      timer = window.setInterval(function() {
               
        updateProgress(videoId , username , event.target.currentTime);    
      }, 3000);
  })
  .on("ended", function() {
      setFinished(videoId , username);
      window.clearInterval(timer);
  })
}

function addDuration(videoId, username) {
  $.post("ajax/addDuration.php", { videoId: videoId, username: username }, function(data) {
      // if(data !== null && data !== "") {
      //     alert(data);
      // }
  })
}


function updateProgress(videoId , username , progress){

  $.post("ajax/updateDuration.php", { videoId: videoId, username: username , progress:progress }, function(data) {
    // if(data !== null && data !== "") {
    //     alert(data);
    // }
})
}

function setFinished(videoId , username){

  $.post("ajax/setFinished.php", { videoId: videoId, username: username  }, function(data) {
    // if(data !== null && data !== "") {
    //     alert(data);
    // }
})
}

function setStartTime(videoId , username){

    $.post("ajax/getProgress.php", { videoId: videoId, username: username  }, function(data) {
      
      if( isNaN(data) ) {
          alert(data);
          return;
        }
      
        $("video").on("canplay" , function(){
         
          this.currentTime = data ;
          $("video").off("canplay");
          
        } ) 

    })

}


function restartVideo(){

    $("video")[0].currentTime = 0 ; 
    $("video")[0].play() ; 
    
    $(".upNext").fadeOut();

}


function watchVideo(videoId){
  window.location.href = "watch.php?id=" + videoId ;
}


function showUpNext(){
   $(".upNext").fadeIn();
}