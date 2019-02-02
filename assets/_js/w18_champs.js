/*
##################################################
	CHAMPS
##################################################
*/
	var Champs = function () {
		var app = {};
		app.Components = {
			Modal 	: Modal(),
			Form  	: Form()
		};
		app.Html = {
			getBody: function(){
				return document.getElementsByTagName("body")[0];
			},
			create: function(type){
				return document.createElement(type);
			},
			getById: function(id){
				var result = null;
				if(document.getElementById(id) != null){
					result = document.getElementById(id);
				}
				return result;
			}
		};
		app.Pages = {
			add: function(data){
				var pages 	= app.Pages,
					totals 	= app.Pages.list.length;
				pages.list[totals] = data;
			},
			list: new Array(),
			start: function(){
				var pages = app.Pages.list;
				for(var i = 0; i < pages.length; i++){
					var page = pages[i];
					if(app.Html.getById(page.id) != null){
						page.load();						
					}
				}
			}
		};
		return app;
	}();
/*
##################################################
	CHAMPS
##################################################
*/