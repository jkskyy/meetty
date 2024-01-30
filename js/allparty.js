ajax();
var script = document.createElement('script');
script.src = 'js/jquery-3.6.0.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);
var counter = 0;
var max = 8;
  let datacountpid = null;
var back = document.getElementById('back');
var next = document.getElementById('next');
const content = document.getElementById('content');
const buttons = document.getElementById('buttons');
$(back).hide();
function ajax() {
const xhr = new XMLHttpRequest();
xhr.onload = function() {
    if (xhr.status === 200) {
        const data = JSON.parse(xhr.response);
        $('#content').html("");
        if(data.length>0)
        {
        datacountpid = data[0].countpid;
        }
        else
        {
          datacountpid = 0;
        }
        while(counter<max)
        {
            if(counter<datacountpid || datacountpid==null)
            {
            content.innerHTML += `<div class="mr-2 ticketWrap ${data[counter].promoted==1 ? 'gradient-box' : ''}">
    <div class="ticket ticketLeft">
      <h1 ${data[counter].promoted==1 ? 'class="promoted"' : ''}>`+ data[counter].partyname +`${data[counter].promoted==1 ? '<br /><i><small>PROMOTED</small></i>' : ''}</h1>
      <div class="title">
        <h2 ${data[counter].promoted==1 ? 'class="promoted"' : ''}><a class="text-decoration-none ${data[counter].promoted==1 ? 'promoted' : ''}" href="profil/`+data[counter].uid + `">` + data[counter].username +`</a></h2>
        <span ${data[counter].promoted==1 ? 'class="promoted"' : ''}>TWÓRCA</span>
      </div>
      <div class="name">
        <h2 ${data[counter].promoted==1 ? 'class="promoted"' : ''}>`+ data[counter].trybik +`</h2>
        <span ${data[counter].promoted==1 ? 'class="promoted"' : ''}>STATUS</span>
      </div>
      <div class="seat">
        <h2 ${data[counter].promoted==1 ? 'class="promoted"' : ''}>`+ data[counter].startdate +`</h2>
        <span ${data[counter].promoted==1 ? 'class="promoted"' : ''}>DATA</span>
      </div>
      <div class="time">
        <h2 ${data[counter].promoted==1 ? 'class="promoted"' : ''}>`+ data[counter].starttime +`</h2>
        <span ${data[counter].promoted==1 ? 'class="promoted"' : ''}>GODZINA</span>
      </div>
      
    </div>
    <div class="ticket ticketRight">
      <div class="number">
      <span ${data[counter].promoted==1 ? 'class="promoted"' : ''}><b>ID</b></span>
        <h3 ${data[counter].promoted==1 ? 'class="promoted"' : ''}><b>`+ data[counter].pid +`</b></h3>
      </div>
      <a class="btn my-2 btn-dark kartabtn ${data[counter].promoted==1 ? 'promoted' : ''}" href="impreza/` + data[counter].pid + `">DO IMPREZY</a>
    </div>
  
  </div>`;
            }
            else
            {
            content.innerHTML += "";
            }
  counter++;
        }
        if(counter<datacountpid)
  {
    $(next).show();
  }
  else
  {
    $(next).hide();
  }
  if(datacountpid==0)
  {
    content.innerHTML = '<h1 class="linkwh my-auto">Ojej! Wygląda na to że nic tu nie ma >.<</h1>';
  }
    }
};
xhr.open("GET", "ajax.php", true);
xhr.send();
}
next.addEventListener('click', function() {
  max = max + 8;
  if(counter<8)
  {
    $(back).hide();
  }
  else
  {
    $(back).show();
  }
  ajax();
  });
  back.addEventListener('click', function() {
    counter = counter - 16;
    max = max - 8;
    if(counter<8)
    {
      $(back).hide();
    }
    else
    {
      $(back).show();
    }
    ajax();
    });