{{-- RichTextEditor JS — self-hosted under public/richtexteditor — https://richtexteditor.com/ --}}
<script src="{{ asset('richtexteditor/rte.js') }}"></script>
<script src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>
<script src="{{ asset('js/admin/blog-blocks-plugin.js') }}?v={{ file_exists(public_path('js/admin/blog-blocks-plugin.js')) ? filemtime(public_path('js/admin/blog-blocks-plugin.js')) : 1 }}"></script>
<script>
  if (window.RTE_DefaultConfig) {
    window.RTE_DefaultConfig.url_base = @json(rtrim(asset('richtexteditor'), '/'));
    window.RTE_DefaultConfig.skin = window.RTE_DefaultConfig.skin || 'default';

    // Configured image styles dropdown options including Top & Bottom margin (20, 10, and 0).
    window.RTE_DefaultConfig.imageStyles = [
      ["Border", "border: 1px solid #ddd; border-radius: 4px; padding: 5px;"],
      ["grayscale", "filter: grayscale(100%);"],
      ["Shadow", "box-shadow:0 0 8px gray"],
      ["Margin Top & Bottom: 20", "margin-top: 20px; margin-bottom: 20px;"],
      ["Margin Top & Bottom: 10", "margin-top: 10px; margin-bottom: 10px;"],
      ["Margin Top & Bottom: 0", "margin-top: 0px; margin-bottom: 0px;"],
      ["Margin10", "margin:10px"],
      ["Margin0", "margin:0px"],
      ["Padding:10", "padding:10px"],
      ["Rounded Corners", "border-radius: 10px;"],
      ["Rounded Images", "border-radius: 50%;"],
      ["Thumbnail Image", "border: 1px solid #ddd; border-radius: 4px; padding: 5px;width:150px"]
    ];

    // Lean toolbar for blog writing — formatting plus public-page visual blocks.
    window.RTE_DefaultConfig.toolbar_blog =
      '{undo,redo}|{bold,italic,underline,strike}|{forecolor}|{justifyleft,justifycenter,justifyright}' +
      '|{insertorderedlist,insertunorderedlist,indent,outdent}|{insertblockquote}' +
      ' #{paragraphs:toggle,fontsize:toggle}' +
      ' / {insertfeaturedimage,inserttakeaways,insertresults,insertchecklist,insertstats,insertchart,insertinsight,insertblogtable}' +
      '|{removeformat}|{insertlink,unlink,insertimage,insertvideo,inserthorizontalrule}|{code}' +
      '#{fullscreenenter,fullscreenexit}';

    window.RTE_DefaultConfig.toolbar = 'blog';
  }
</script>
