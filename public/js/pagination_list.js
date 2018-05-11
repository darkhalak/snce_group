/**
 * @author Daniele Agrelli <daniele.agrelli@gmail.com> on 11/05/18 11:26.
 * @copyright Copyright © Daniele Agrelli 2018
 */

var pagination_list='#pagination__list_product';
var pagination_list_item= '#pagination__list_product .list__product_item';

$('#search').on('keyup input', function () {
    var yourtext = $(this).val();
    if (yourtext.length > 0) {
        var abc = $(pagination_list_item).filter(function () {
            var str = $(this).text();
            var re = new RegExp(yourtext, "i");
            var result = re.test(str);

            if (!result) {
                return $(this).fadeOut(200)
            }else{
                return $(this).fadeIn(200)
            }
        });

    } else {
        $(pagination_list_item).fadeIn(200);
    }
});