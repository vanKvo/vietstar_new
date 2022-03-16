/** Searchable dropdown list **/
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function toggleFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("p");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

  /** Toggle dashboard */
  $(".toggle-navbar-btn").click(function(){
    $(".navbar-primary").toggle();
  });


/** Toggle the vertical navbar-primary menu */
$(document).ready(function(){
  $('.btn-expand-collapse').click(function(){
    $(".navbar-primary").toggle();
  });
});

/** Test */
feather.replace();    

    $(document).ready(function(){
        $('.toggle input[type="checkbox"]').click(function(){
            $(this).parent().toggleClass('on');

            if ($(this).parent().hasClass('on')) {
                $(this).parent().children('.label').text('On')
            } else {
                $(this).parent().children('.label').text('Off')
            }
        });

        $('.checkbox input[type="checkbox"]').click(function(){
            $(this).parent().toggleClass('on');

            if ($(this).parent().hasClass('on')) {
                $(this).parent().children('.label').text('On')
            } else {
                $(this).parent().children('.label').text('Off')
            }
        });

        $('.radio input[type="radio"]').click(function(){
            $(this).parent().addClass('on');

            if ($(this).parent().hasClass('on')) {
                $(this).parent().children('.label').text('On')
            }
        });
        $('input').focusin (function() {
            $(this).parent().addClass('focus');
        });
        $('input').focusout (function() {
            $(this).parent().removeClass('focus');
        });
    });