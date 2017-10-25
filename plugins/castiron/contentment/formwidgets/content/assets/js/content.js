function makeSortable() {
  var $contentList = $('#content-list'),
    $sorter = $('#content-list-sorter');

  if ($contentList.find('.content-panel').length < 2) {
    return;
  }

  $contentList.sortable({
    containerSelector: '#content-list',
    itemSelector: '.content-panel',
    handle: '.content-panel-toolbar',
    useAnimation: false,
    usePlaceholderClone: true,
    placeholder: '<div class="content-panel placeholder"></div>',
    onDrop: function ($item, container, _super, event) {
      var ids = [];
      $contentList.find('.content-panel').each(function (i, el) {
        ids.push($(el).data('content-id'));
      });

      $sorter.data('request-data', {content_ids: ids});
      $sorter.request($sorter.data('request'))

      _super.apply(this, arguments);
    }
  });
}


$(function () {
  makeSortable();
  $(document).on('ajaxUpdate', '#content-list', makeSortable);

});
