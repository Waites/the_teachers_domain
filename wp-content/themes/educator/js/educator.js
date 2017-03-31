
var menuItem = document.querySelectorAll('.menu-item-object-custom');
var edSelSlide = document.querySelector('#ed-selectable-slider');


for (var i = 0; i < menuItem.length; i++ ){
	menuItem[i].addEventListener("click", function(){
		edSelSlide.style.display = "inline-block";
	});

}

//make posts clickable
var posts = document.querySelectorAll('.post');
if (document.querySelector('.post .entry-title:first-child a') != null && posts.length > 0){
	posts.forEach(function(post){
		var link = post.querySelector('.entry-title:first-child a').href;
		post.addEventListener("click", function(){
			window.location.href = link;
		});
	});
}
