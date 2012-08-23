google.setOnLoadCallback( function () {
	$("a.previousbutton").attr("href","#");
	$("a.nextbutton").attr("href","#");
	
	var imagecount = parseInt($("ul.images li").length);
	var page = parseInt($("input#hidPage").val());
	var imagesPerPage = parseInt($("input#hidImagesPerPage").val());
	var wholeImageCount = parseInt($("input#hidImagesCount").val());
	
	$("ul.images a").live("click", function () {
		$("div.bigImage").remove();
		$("div.gallery").hide();
		var imagesrc = $(this).attr("href");
		var imagetitle = $(this).find("span.title").html();
		$("body").prepend("<div class=\"bigImage\" style=\"display: none;\"><img src=\"" + imagesrc + "\" /><span class=\"title\">" + imagetitle + "</span></div>");
		$("div.bigImage").fadeIn();
		return false;
	});
	
	$("div.bigImage img").live("click", function () {
		$("div.bigImage").remove();
		$("div.gallery").fadeIn();
	});
	
	$("a.nextbutton").live("click", function () {
		
		var nextpage = page + 1;
		$("div.loadingbg").fadeIn();
		$.post("ajaxLoadImage.php", {page: nextpage, imagesPerPage: imagesPerPage}, function (data) {
			$("ul.images").replaceWith(data);
			$("div.loadingbg").hide();
		});
		
		$("input#hidPage").attr("value", nextpage);
		page = nextpage;
		
		changeButtons(page, imagesPerPage, wholeImageCount);
	});
	
	$("a.previousbutton").live("click", function () {
		var previouspage = page - 1;
		$("div.loadingbg").fadeIn();
		$.post("ajaxLoadImage.php", {page: previouspage, imagesPerPage: imagesPerPage}, function (data) {
			$("ul.images").replaceWith(data);
			$("div.loadingbg").hide();
		});
		
		$("input#hidPage").attr("value", previouspage);
		page = previouspage;
		
		changeButtons(page, imagesPerPage, wholeImageCount);
	});
});

function changeButtons(page, imagesPerPage, wholeImageCount)
{
	if(page == 0)
	{
		$(".previousbutton").replaceWith("<span class=\"button previousbutton\">Zur&uuml;ck</span>");
	}
	else
	{
		$(".previousbutton").replaceWith("<a href=\"#\" class=\"button previousbutton\">Zur&uuml;ck</a>");
	}
	
	if((page + 1) * imagesPerPage >= wholeImageCount)
	{
		$(".nextbutton").replaceWith("<span class=\"button nextbutton\">Weiter</span>");
	}
	else
	{
		$(".nextbutton").replaceWith("<a href=\"#\" class=\"button nextbutton\">Weiter</a>");
	}
}
