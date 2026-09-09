{{-- RichTextEditor JS — self-hosted under public/richtexteditor — https://richtexteditor.com/ --}}
<script src="{{ asset('richtexteditor/rte.js') }}"></script>
<script src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>
<script src="{{ asset('js/admin/blog-blocks-plugin.js') }}"></script>
<script>
  if (window.RTE_DefaultConfig) {
    window.RTE_DefaultConfig.url_base = @json(rtrim(asset('richtexteditor'), '/'));
    window.RTE_DefaultConfig.skin = window.RTE_DefaultConfig.skin || 'default';

    // Lean toolbar for blog writing — formatting plus public-page visual blocks.
    window.RTE_DefaultConfig.toolbar_blog =
      '{undo,redo}|{bold,italic,underline,strike}|{forecolor}|{justifyleft,justifycenter,justifyright}' +
      '|{insertorderedlist,insertunorderedlist,indent,outdent}|{insertblockquote}' +
      ' #{paragraphs:toggle,fontsize:toggle}' +
      ' / {inserttakeaways,insertresults,insertchecklist,insertstats,insertchart,insertinsight,insertblogtable}' +
      '|{removeformat}|{insertlink,unlink,insertimage,insertvideo,inserthorizontalrule}|{code}' +
      '#{fullscreenenter,fullscreenexit}';

    window.RTE_DefaultConfig.toolbar = 'blog';
  }
</script>
