function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown");
    a = div.getElementsByTagName("button");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}

function openTab(index)
{
    var element = document.getElementsByTagName('div');
    var name = "";
    var obj;

    for (var i = 0; i < element.length; i++)
    {
        name = element[i].id;
        if (name.substr(0,8) == 'tab_box_')
        {
            obj = document.getElementById(name);

            obj.hidden = true;

        }
        if (name.substr(0,8) == 'tab_top_')
        {
            obj = document.getElementById(name);
            obj.setAttribute('class','tab_top_passive');
        }

    }
    var tab = document.getElementById("tab_box_"+index);
    tab.hidden = false;
    tab = document.getElementById("tab_top_"+index);
    tab.setAttribute('class','tab_top_active');

}