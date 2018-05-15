/**
 * @author Daniele Agrelli <daniele.agrelli@gmail.com> on 14/05/18 09:32.
 * @copyright Copyright © Daniele Agrelli 2018
 */
var $collectionHolder;

// setup an "add a tag" link
var $addTagLink = $('<a href="#" class="add_tag_link btn btn-sm btn-info"><span class="glyphicon glyphicon-plus"></span> Add a tag</a>');
var $newLinkLi = $('<div></div>').append($addTagLink);

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in ProductType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div class="form-group"></div>').append(newForm);
    $newLinkLi.before($newFormLi);
}
function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#">delete this tag</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

jQuery(document).ready(function() {
    // Get the div that holds the collection of tags
    $collectionHolder = $('div.tags');

    // add a delete div to all of the existing tag form div elements
    $collectionHolder.find('div.tags-setted').each(function() {
        addTagFormDeleteLink($(this));
    });
    // add the "add a tag"
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    if($collectionHolder.find('div.tags-setted').length == 0){
        addTagForm($collectionHolder, $newLinkLi);
    }

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
});