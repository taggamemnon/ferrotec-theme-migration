var ferroData=null;
var src_loaded=true;
function load_report_info(func,mode)
{
if (mode == '')
  var mode = 0; 
  var retval='';
  //MAKE SURE WE ARE NOT IN THE PROCESS OF RETRIEVING DATA
  if((ferroData==null||ferroData=='')&&src_loaded)
  {
    //IF NOT IN PROCESS CREATE SCRIT ELEMENT AND SET ITS SOURCE TO THE DATA RETRIVE SYSTEM
    src_loaded=false; 
	 
    cust_data  = '&mode='+mode;
    cust_data += '&ambTemp='+document.getElementById('ambTemp').value;
    cust_data += '&coldTemp='+document.getElementById('coldTemp').value;
    cust_data += '&thermRes='+document.getElementById('thermRes').value;
    cust_data += '&heatTrans='+document.getElementById('heatTrans').value;
    if(document.getElementById('multMod').checked)
      cust_data += '&multMod=1';
    else
      cust_data += '&multMod=0';
    elem=document.createElement('script');
    document.body.appendChild(elem);

    elem.src='/terecommend?instruct='+document.getElementById('myform').sort.value+'&family='+document.getElementById('myform').family.value+cust_data;
    //elem.src='/terecommend?family='+document.getElementById('myform').family.value+cust_data;
    disable_screen();
    //CALL TIMING FUNCTION
    setTimeout(func, 200);
    //setPointer();
  }
  else if(!src_loaded)
  {
    //IF RETRIVE IS IN PROGREESS CALL THE TIMING FUNCTION AGAIN
    setTimeout(func, 1000);
  }
  return retval;
}

function do_interactive_sort(mode)
{
  //RETREIVE LIST DISPLAY ELEMENT
  var elem=document.getElementById('list_display');
  //DETERMINE IF THERE IS DATA THAT HAS BEEN RETURNED
  x = ferroData;
  if(x!=null&&x!=''&&src_loaded)
  {
    //IF DATA WAS RETURNED INSERT IT
    //resetPointer();
    elem.innerHTML=x;
    jQuery('#listing').tablesorter({ widgets:['zebra']});
    enable_screen();
    ferroData=null;
  }
  else
  {
    //IF DATA IS NOT RETUNRED THEN GO RETRIVE IT
    if((src_loaded==''||src_loaded==null)&&src_loaded!=false)
      src_loaded=true;
    load_report_info("do_interactive_sort("+mode+");",mode);
  }
}


function build_sort(newsort,order)
{
  //remove newsort from anywhere in the sort element value
  x=document.getElementById('myform').sort.value;
  y=x.split("/");
  var a=new Array();
  for(i=0,j=0;i<y.length;i++)
  {
    z=y[i].split(":");
    if(z[0]==newsort)
      continue;
    else
      a[j++]=y[i];
  }
  x=a.join("/");
  //add newsort to the end of sort element
  x=x+"/"+newsort+":"+order;
  document.getElementById('myform').sort.value=x;
}

var cust_arr=new Array('ambTemp'	,'coldTemp'	,'thermRes',	'heatTrans');
var default_arr=new Array('50'		,'10'		,'0',		'30');

function if_true_get(newsort,order,mode)
{
  truth = 1;

  // checks to see if thermal coefficient is greater than 2
  if (document.getElementById('thermRes').value >2 && mode==1)
  {
    alert("Thermal Coefficient must not be greater than 2");
    truth = 0; 
  }
  // checks to see if all fields are entered
  for (i=0;i<cust_arr.length;i++)
  {
    if (document.getElementById(cust_arr[i]).value =='' && mode==1)
    {
      document.getElementById(cust_arr[i]).value = default_arr[i];
      truth = 1; break;
    }

    if(isNaN(document.getElementById(cust_arr[i]).value))
    {
      alert("you must enter number values");
      truth = 0; break;
    }
  }
  if (truth == 1)
  {
    build_sort(newsort,order);
    do_interactive_sort(mode);
  }
}

function disable_screen()
{
  var x,y,t,l;
  if (self.innerHeight) // all except Explorer
  {
        x = self.innerWidth;
        y = self.innerHeight;
        t = window.pageYOffset;
  }
  else if (document.documentElement && document.documentElement.clientHeight)
        // Explorer 6 Strict Mode
  {
        x = document.documentElement.clientWidth;
        y = document.documentElement.clientHeight;
        t = document.documentElement.scrollTop;
  }
  else if (document.body) // other Explorers
  {
        x = document.body.clientWidth;
        y = document.body.clientHeight;
        t = document.body.scrollTop;
  }

  var a=document.getElementById('disable_screen');

  a.style.visibility='visible';
  a.style.display='block';
  a.style.top=t+'px';
  a.style.height=y+'px';
  a.style.width=x+'px';
  var b=document.getElementById('loading');
  b.style.visibility='visible';
  b.style.display='block';
  b.style.top=t+Math.round(y/2-100/2)+'px';
  b.style.left=Math.round(x/2-150/2)+'px';
}

function enable_screen()
{
  var x=document.getElementById('disable_screen');
  x.style.visbility='hidden';
  x.style.display='none';
  var y=document.getElementById('loading');
  y.style.visbility='hidden';
  y.style.display='none';
}