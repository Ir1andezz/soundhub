
var pops = document.getElementsByClassName('add_to_playlist');
var btns = document.querySelectorAll('div.add_to_playlist-button');
var playId;

for(i=0;i<pops.length;i++){
  pops[i].setAttribute('id', 'play-list-'+i);
  pops[i].setAttribute('data-state', 'close');
}

for(a=0;a<btns.length;a++){
  btns[a].setAttribute('data-play-list-id', a);
  btns[a].addEventListener('click', function(){
    playId = this.getAttribute('data-play-list-id');
    let pop = document.getElementById('play-list-'+playId);

    for(i=0;i<pops.length;i++){
      pops[i].style.display = 'none';
    }

    if(pop.getAttribute('data-state') == 'close'){

      pop.style.display = 'block';
      pop.setAttribute('data-state', 'open');
    }
  })
}


  window.addEventListener('click', function(e){
    let target = e.target;
    if (!target.closest('.add_to_playlist-button')) { 
      console.log(playId);
      document.getElementById('play-list-'+playId).style.display = "none";
      document.getElementById('play-list-'+playId).setAttribute('data-state', 'close');
    }
  }) 



