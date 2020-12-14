/**
 * Inclui arquivo javascript dentro de um script JS
 * 
 * @param string path
 * @returns void
 */
function include(path){
    var j = document.createElement("script");
    j.type = "text/javascript";
    j.src = path;
    document.body.appendChild(j);
    //document.body.appendedNode(j)
}

/**
 * Inclui o arquivo uma única vez no contexto da aplicação
 * 
 * @param string file_path
 * @returns void
 */
function include_once(file_path) {
    var sc = document.getElementsByTagName("script");
    for (var x in sc)
        if (sc[x].src != null && sc[x].src.indexOf(file_path) != -1) return;
    include(file_path);
}

include('js/jquery-1.10.2.min.js');
include('js/jquery.mask.js');
include('js/jscalendar/js/jscal2.js');
include('js/jscalendar/js/lang/pt.js');
include('js/bootstrap.js');
include('js/comum.js');
include('js/crud.js');
include('js/frmBuscaServidor.js');
include('js/frmFolhaPonto.js');