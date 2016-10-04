$(document).ready(function(){
  id_collapse();
  // id_collapse_text();
  // id_collapse_ousadresser();
  id_tab_situations();

  if (typeof $.fn.popover == 'undefined') {
    no_bootstrap_tab();
  }
});

function no_bootstrap_tab(){
  $('.tabs').each(function(i){
    var parent = $(this);
    $('> .nav-tabs > li > a', parent).click(function(e){
      e.preventDefault();

      var id = $(this).attr('href');
      $('> .nav-tabs > li', parent).each(function(index){
          $(this).removeClass('active');
      });

      $('> .tab-content > .tab-pane', parent).each(function(index){
          $(this).removeClass('active');
      });

      $(this).parent().addClass('active');
      $('> .tab-content '+ id,parent).addClass('active');
    });
  });
}

function id_collapse(){
  $('.panel-group').each(function(i){
    $(this).attr('id','accordion_'+i);
    $('> .panel',this).each(function(index){
      $('> .panel-heading', this).attr('id','heading_'+i+'_'+index);
      $('> .panel-heading .panel-title a',this).attr({
        'data-parent':'#accordion_'+i,
        'href':'#collapse_'+i+'_'+index,
        'aria-controls':'collapse_'+i+'_'+index
      });
      $('.panel-collapse.collapse', this).attr({
        'id':'collapse_'+i+'_'+index,
        'aria-labelledby':'heading_'+i+'_'+index
      });
      if(index > 0){
        $('.panel-collapse.collapse', this).removeClass('in');
      }
    });
  });
};

function id_collapse_text(){
  $('.texte.panel-group').each(function(i){
    $(this).attr('id','accordion_'+i);
    $('> .chapitre',this).each(function(index){
      $('> .panel-heading', this).attr('id','heading_'+i+'_'+index);
      $('> .panel-heading .panel-title a',this).attr({
        'data-parent':'#accordion_'+i,
        'href':'#collapse_'+i+'_'+index,
        'aria-controls':'collapse_'+i+'_'+index
      });
      $('.panel-collapse.collapse', this).attr({
        'id':'collapse_'+i+'_'+index,
        'aria-labelledby':'heading_'+i+'_'+index
      });
      if(index > 0){
        $('.panel-collapse.collapse', this).removeClass('in');
      }
    });
  });
};

function id_collapse_ousadresser(){
  $('.ousadresser').each(function(i){
    $('.chapitre',this).each(function(index){
      $('> .panel-heading', this).attr('id','ousadresser_heading_'+i+'_'+index);
      $('> .panel-heading .panel-title a',this).attr({
        'data-parent':'#ousadresser_accordion_'+i,
        'href':'#ousadresser_collapse_'+i+'_'+index,
        'aria-controls':'ousadresser_collapse_'+i+'_'+index
      });
      $('.panel-collapse.collapse', this).attr({
        'id':'ousadresser_collapse_'+index,
        'aria-labelledby':'ousadresser_heading_'+i+'_'+index
      });
      $('.panel-collapse.collapse', this).removeClass('in');
    });
  });
};

function id_tab_situations(){
  $('.tabs').each(function(i){
    $('> .nav-tabs > li',this).each(function(index){
      $(this).attr('role','tab_'+i+'_'+index);
      $('> a',this).attr({
        'href':'#tab_'+i+'_'+index,
        'aria-controls':'tab_'+i+'_'+index,
      });
      if(index > 0){
        $(this).removeClass('active');
      }
    });
    $('> .tab-content > .tab-pane', this).each(function(index){
      $(this).attr('id','tab_'+i+'_'+index);
      if(index > 0){
        $(this).removeClass('active');
      }
    });
  });
}
