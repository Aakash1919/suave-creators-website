{{-- RichTextEditor JS — self-hosted under public/richtexteditor — https://richtexteditor.com/ --}}
<script src="{{ asset('richtexteditor/rte.js') }}"></script>
<script src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>
<script>
  if (window.RTE_DefaultConfig) {
    window.RTE_DefaultConfig.url_base = @json(rtrim(asset('richtexteditor'), '/'));
    window.RTE_DefaultConfig.skin = window.RTE_DefaultConfig.skin || 'default';

    // Lean toolbar for blog writing — no template / delete / comment / admin clutter.
    window.RTE_DefaultConfig.toolbar_blog =
      '{bold,italic,underline,strike}|{forecolor}|{justifyleft,justifycenter,justifyright}' +
      '|{insertorderedlist,insertunorderedlist,indent,outdent}|{insertblockquote}' +
      ' #{paragraphs:toggle,fontsize:toggle}' +
      ' / {removeformat}|{insertlink,unlink,insertimage,insertvideo,inserthorizontalrule,inserttable}|{code}' +
      '#{fullscreenenter,fullscreenexit,undo,redo}';

    window.RTE_DefaultConfig.toolbar = 'blog';
  }
</script>
