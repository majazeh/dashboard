(function () {
	var _globals = {
		title: function (value) {
			$('title').html(value);
		}
	};

	var _ajax = {
		type: 'GET',
		cache: false
	};

	var _options = {
		object: null,
		title: null,
		ajax: _ajax,
		/**
   * Send request and change url with response rendering
   * @default both
   * both: change url and render response
   * url: Only send request and chage url without change rendering
   * render: Only send request and render repsonse without change url
   * @type {String}
   */
		type: 'both',
		/**
   * dont send any request
   * @type {Boolean}
   */
		fake: false,
		/**
   * ajax response contetnt
   * if {fake:true} or {response : notnull} response render this property
   * @type {[type]}
   */
		response: null,
		/**
   * replace state
   * @type {Boolean}
   */
		replace: false,
		/**
   * event context
   * @type {DOM} {jQuery} {Selector string}
   */
		context: document
	};

	function statio(custom) {
		if (typeof custom != 'object') {
			custom = {};
		}

		custom.ajax = $.extend({}, _ajax, custom.ajax);
		custom.ajax.url = custom.url;
		custom.globals = $.extend({}, _globals, custom.globals);
		var options = $.extend({}, _options, custom);

		var response = {
			body: options.response,
			data: {}
		};

		if (!(options.context instanceof jQuery)) {
			options.context = $(options.context);
		}

		$(document).trigger('statio:global:init', [options.context]);
		options.context.trigger('statio:init');

		if (options.type != 'render') {
			try {
				options.replace ? history.replaceState(options.data, options.title, options.url) : history.pushState(options.data, options.title, options.url);
			} catch (e) {
				console.error(e);
			}
		}

		if (!options.fake) {
			if (!options.ajax.complete) {
				options.ajax.complete = ajx_complete;
			}
			$.ajax(options.ajax);
		} else if (options.type != 'url' && response.body) {
			response_parse();
			render();
			$(document).trigger('statio:global:done', [options.context]);
			options.context.trigger('statio:done');
		} else {
			$(document).trigger('statio:global:done', [options.context]);
			options.context.trigger('statio:done');
		}

		function ajx_complete(jqXHR, textStatus) {
			if (jqXHR.responseJSON) {
				response.data = jqXHR.responseJSON;
				$(document).trigger('statio:global:jsonResponse', [options.context, jqXHR.responseJSON, jqXHR]);
				options.context.trigger('statio:jsonResponse', [jqXHR.responseJSON, jqXHR]);
			} else {
				response.body = jqXHR.responseText;
				response_parse();
				if (textStatus == 'success') {
					$(document).trigger('statio:global:success', [options.context, response.data, response.body, jqXHR]);
					options.context.trigger('statio:success', [response.data, response.body, jqXHR]);
					if (options.type != 'url') {
						render();
					}
				} else {
					$(document).trigger('statio:global:errorResponse', [options.context, response.data, response.body, jqXHR]);
					options.context.trigger('statio:errorResponse', [response.data, response.body, jqXHR]);
				}
			}
			$(document).trigger('statio:global:done', [options.context, response.data, response.body, jqXHR]);
			options.context.trigger('statio:done', [response.data, response.body, jqXHR]);
		}

		function response_parse() {
			if (typeof response.body == 'string') {
				try {
					var split = response.body.split("\n");
					response.data = JSON.parse(split[0]);
					response.body = split.length > 1 ? $($.parseHTML(split.splice(1).join(""))) : null;
				} catch (e) {
					response.body = $($.parseHTML(response.body));
				}
			} else if (typeof response.body == 'object' && response.body != null) {
				if (response.body instanceof HTMLElement) {
					response.body = $(response.body);
				} else if (response.body instanceof jQuery) {} else {
					response.data = response.body;
					response.body = null;
				}
			}
		}

		function render() {
			for (D in response.data) {
				if (options.globals[D]) {
					options.globals[D](response.data[D]);
				}
			}
			if (response.body) {
				var changed = [];
				response.body.each(function () {
					var base = $(this).attr('data-xhr');
					if (base) {
						changed.push($("[data-xhr='" + base + "']"));
						$("[data-xhr='" + base + "']").html($(this).html());
					}
				});
				$(document).trigger('statio:global:renderResponse', [$(changed), options.context, response.data, response.body]);
				options.context.trigger('statio:renderResponse', [$(changed), response.data, response.body]);
			}
		}
		return this;
	}
	window.Statio = statio;
	/**
  * for new chrome bug
  */
	new Statio({
		url: location.href,
		fake: true,
		replace: true
	});

	/**
  * popstate event
  */
	window.onpopstate = function (event) {
		new Statio({
			url: location.href,
			replace: true
		});
	};
})();
var media_xm = window.matchMedia("(max-width: 575.98px)");
var media_sm = window.matchMedia("(min-width: 576px) and (max-width: 767.98px)");
var media_md = window.matchMedia("(min-width: 768px) and (max-width: 991.98px)");
var media_lg = window.matchMedia("(min-width: 992px) and (max-width: 1199.98px)");
var media_xl = window.matchMedia("(min-width: 1200px)");

function event_media_xm(media) {
	if (media.matches) return $(document).trigger('media:xm', [media]);else return $(document).trigger('media:xm:exit', [media]);
}
function event_media_sm(media) {
	if (media.matches) return $(document).trigger('media:sm', [media]);else return $(document).trigger('media:sm:exit', [media]);
}
function event_media_md(media) {
	if (media.matches) return $(document).trigger('media:md', [media]);else return $(document).trigger('media:md:exit', [media]);
}
function event_media_lg(media) {
	if (media.matches) return $(document).trigger('media:lg', [media]);else return $(document).trigger('media:lg:exit', [media]);
}
function event_media_xl(media) {
	if (media.matches) return $(document).trigger('media:xl', [media]);else return $(document).trigger('media:xl:exit', [media]);
}

$(document).ready(function () {
	event_media_xm(media_xm);
	media_xm.addListener(event_media_xm);

	event_media_sm(media_sm);
	media_sm.addListener(event_media_sm);

	event_media_md(media_md);
	media_md.addListener(event_media_md);

	event_media_lg(media_lg);
	media_lg.addListener(event_media_lg);

	event_media_xl(media_xl);
	media_xl.addListener(event_media_xl);
});

$(document).on('media:xm', function (event, media) {
	$('#btn-menu').on('click', function () {
		if ($(this).is('.menu-open, .menu-back')) {
			$('#menu').css('opacity', 0);

			$('#sidebar').addClass('d-flex').removeClass('d-none');
			$('#menu').addClass('d-flex').removeClass('d-none');
			$(this).addClass('menu-close').removeClass('menu-open').removeClass('menu-back');
			$('#menu').fadeTo('fast', 1);
		} else if ($(this).is('.menu-close')) {
			$('#menu').fadeTo('fast', 0, function () {
				$('#sidebar').addClass('d-none').removeClass('d-flex');
				$('#menu').addClass('d-none').removeClass('d-flex');
				$('#btn-menu').addClass('menu-open').removeClass('menu-close');
				$('#menu').css('opacity', 1);
			});
		}
	});
});
$(document).on('media:xm:exit', function (event, media) {
	$('#btn-menu').off('click');
});

$(document).on('media:xm media:lg media:xl media:sm media:md', function (event, media) {
	$('#desktop').removeClass('active');
	$(document).off('click.active-desktop');
	$('#sidebar').off('click.active-desktop');
	$('#menu .menu-item').off('click.active-desktop');
});

$(document).on('media:xm media:sm media:md', function (event, media) {
	$('#menu .menu-item').on('click.active-desktop', function () {
		$('#desktop').css('opacity', 0).addClass('active');
		$('#desktop').fadeTo('fast', 1);
		$(document).on('click.active-desktop', function (e) {
			if ($('#desktop').is('.active')) {
				$('#desktop').fadeTo('fast', 0, function () {
					$(this).removeClass('active');
					$(this).fadeTo('fast', 1);
				});
				$(document).off('click.active-desktop');
			}
		});
		if (media_xm.matches) {
			$('#btn-menu').addClass('menu-back').removeClass('menu-close').removeClass('menu-open');
		}
	});
	$('#sidebar').on('click.active-desktop', function (event) {
		event.stopImmediatePropagation();
	});
});

$("#menu .menu-item").on('click.desktop-show', function () {
	var desktop = $("#desktop").attr('data-href');
	var href = $(this).attr('href');
	var subcontent = $("#desktop .desktop-subcontent[data-desktop='" + href + "']").length;
	if (desktop == href || !subcontent) {
		return true;
	} else {
		$("#desktop").attr('data-href', href);
		$("#desktop .desktop-subcontent").removeClass('active');
		$("#desktop .desktop-subcontent[data-desktop='" + href + "']").addClass('active');
		return false;
	}
});