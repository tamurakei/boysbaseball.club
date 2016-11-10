(function ($, app) {

	function getOriginalImageSizes(img) {
		var tempImage = new Image(),
			width,
			height;
		if ('naturalWidth' in tempImage && 'naturalHeight' in tempImage) {
			width = img.naturalWidth;
			height = img.naturalHeight;
		} else {
			tempImage.src= img.src;
			width = tempImage.width;
			height = tempImage.height;
		}
		return {
			width: width,
			height: height,
		};
	}

	function calculateImages($table) {
		var $images = $table.find('img');
		if ($images.length > 0 && /firefox|trident|msie/i.test(navigator.userAgent)) {
			$images.hide();
			$.each($images, function(index, el) {
				var $img = $(this),
					originalSizes = getOriginalImageSizes(this);
				if ($img.closest('td, th').width() < originalSizes.width) {
					$img.css('width', '100%');
				}
			});
			$images.show();

		}
	}

	$(document).ready(function () {
		$('.supsystic-table').each(function () {
			var table = $(this),
				format = table.data('currency-format'),
                formatWithoutCurrency = format.match(/\d.*\d/)[0],
                currencySymbol = format.replace(formatWithoutCurrency, '') || '$',
                formatDelimiters = (formatWithoutCurrency.match(/[^\d]/g) || ['.', ',']).reverse(),
                delimiters = {
                    decimal: formatDelimiters[0],
                    thousands: formatDelimiters[1]
                },
                languageData = numeral.languageData(),
                _numeral = numeral;

                languageData.currency.symbol = currencySymbol;
                languageData.delimiters = delimiters;

                _numeral.language(this.id, languageData);
                _numeral.language(this.id);

			if (table.is(':visible')) {
				// Fix bug in FF and IE wich not supporting max-width 100% for images in td
				calculateImages(table);
			}

			var dataTableInstance = app.initializeTable(this, app.showTable(table));

			if (!table.data('head')) {
				table.find('th').removeClass('sorting sorting_asc sorting_desc sorting_disabled');
			}

			table.bind('column-visibility.dt draw.dt', function (e) {

				table.find('td, th').each(function () {
					var color = /color\-([0-9abcdef]{6})/.exec(this.className),
						background = /bg\-([0-9abcdef]{6})/.exec(this.className);

					if (null !== color) {
						$(this).css({color: '#' + color[1]});
					}

					if (null !== background) {
						$(this).css({backgroundColor: '#' + background[1]});
					}
				});
			});
			
			function formatCurrency() {
				table.find('[data-cell-type="numeric"]').each(function(index, el) {
					var $this = $(this),
						format = $this.data('cell-format').replace(
						formatWithoutCurrency,
						formatWithoutCurrency
							.replace(delimiters.decimal, '.')
							.replace(delimiters.thousands, ',')
						);

					$this.text(_numeral($this.text()).format(format));
				});
			}

			formatCurrency();

			$(document).on('click', '.paginate_button', function () {
				formatCurrency();
			});

			table.trigger('draw.dt');

			// Custom css
			var $css = $('#' + table.attr('id') + '-css');
			if ($css.length) {
				$('head').append($('<style/>').text($css.text()));
				$css.remove();
			}

			// This is used when table is hidden in tabs and can't calculate itself width to ajust on small screens
			if (!table.is(':visible')) {
				table.data('isVisible', setInterval(function(){
					if (table.is(':visible')) {
						clearInterval(table.data('isVisible'));
						dataTableInstance.api().responsive.recalc();
						calculateImages(table);
					}
				}, 250));
			}
			var responsiveMode = table.data('responsive-mode');
			if (responsiveMode === 0) {

				var labelStyles = '<style>',
					id = '#' + table.attr('id');
				table.find('thead th').each(function(index, el) {
					labelStyles += id + '.oneColumnWithLabels td:nth-of-type(' + (index + 1) + '):before { content: "' + $(this).text() + '"; }';
				});
				labelStyles += '</style>';
				table.append(labelStyles);
				$(window).on('resize', table, function(event) {
					event.preventDefault();

					clearTimeout(table.data('resizeTimer'));

					table.data('resizeTimer', setTimeout(function() {
						table.removeClass('oneColumn oneColumnWithLabels');
						var tableWidth = table.width(),
							wrapperWidth = table.closest('.supsystic-tables-wrap').width();
						if (tableWidth > wrapperWidth) { 
							table.addClass('oneColumn');

							if (table.data('head') == 'on') {
								table.addClass('oneColumnWithLabels');
							}
						}
					}, 150));

				}).trigger('resize');
			} else if (responsiveMode === 2) {
				table.closest('.supsystic-tables-wrap').css('overflow-x', 'auto');
			}

			// Show comments on tap
			if ('ontouchstart' in window || navigator.msMaxTouchPoints) {
				table.find('td, th').on('click', function(e) {
					var $this = $(this),
						title = $this.attr('title');

						if (title) {
							var div = $('<div style="display:none;' +
							'position:absolute;' +
							'border-radius:6px;' +
							'background-color:#999;' +
							'color:white;' +
							'padding:7px;"/>');

							div.text(title)
								.appendTo('body')
								.css('top', (e.pageY - 70) + 'px')
								.css('left', (e.pageX + 20) + 'px')
								.fadeIn('slow');

							setTimeout(function() {
								div.fadeOut();
							}, 1200);

						}
		        });
			}

		});
	});

}(window.jQuery, window.supsystic.Tables));