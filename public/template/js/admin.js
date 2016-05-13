function autoResize()
{
	var auto_resize = document.getElementsByName('auto_resize')[0].checked;
	if(auto_resize == false)
	{
		document.getElementsByName('video_width')[0].style = "display:none";
		document.getElementsByName('video_height')[0].style = "display:none";
		document.getElementsByName('video_width')[0].removeAttribute('required');
		document.getElementsByName('video_height')[0].removeAttribute('required');
		document.getElementsByName('video_width')[0].value = "";
		document.getElementsByName('video_height')[0].value = "";
	}
	else
	{
		document.getElementsByName('video_width')[0].style = "display:block";
		document.getElementsByName('video_height')[0].style = "display:block";
		document.getElementsByName('video_width')[0].setAttribute('required',true);
		document.getElementsByName('video_height')[0].setAttribute('required',true);	
	}
}