if (document.getElementById){
    document.write('<style type="text/css">\n')
    document.write('.dropcontent{display:none;}\n')
    document.write('</style>\n')
}

function contractall(){
    if (document.getElementById){
        var inc=0
        while (document.getElementById("dropmsg"+inc)){
            document.getElementById("dropmsg"+inc).style.display="none"
            inc++
        }
    }
}

function expandone(){
    if (document.getElementById){
        //var selectedItem=document.dropmsgform.dropmsgoption.selectedIndex
        var selectedItem=document.getElementById("makhung").selectedIndex
        contractall()
        document.getElementById("dropmsg"+selectedItem).style.display="block"
    }
}

if (window.addEventListener)
    window.addEventListener("load", expandone, false)
else if (window.attachEvent)
    window.attachEvent("onload", expandone)