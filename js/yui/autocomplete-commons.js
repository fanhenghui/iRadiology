function initAutocomplete(controlId, serviceUrl)
{
    function createAutocomplete(id, serviceUrl)
    {
        function createDivIfNotExists(id, parent)
        {
            var control;
            if (!(control = document.findElementById(id)))
            {
                control = document.createElement("div");
                control.setAttribute("id", id);
                document.body.appendChild(control);
            }
            control.className = controlId + "_container";
        }
        var css = document.body.className;
        if (css.toLowerCase().indexOf('yui-skin-sam') == -1) css += " yui-skin-sam";
        document.body.className = css.replace(/^[\s]*/m, "");
        var ds = new YAHOO.util.XHRDataSource(serviceUrl);
        ds.responseType = YAHOO.util.XHRDataSource.TYPE_JSON;
        ds.responseSchema = {resultsList: "Result", fields: [{key: "[0]"}]};
        createDivIfNotExists(id + "_container", document.findElementById(id).parentNode);
        var autocomp = new YAHOO.widget.AutoComplete(document.findElementById(id), document.findElementById(id + "_container"), ds);
        document.findElementById(id).className = document.findElementById(id).className.replace("yui-ac-input", "");
        autocomp.queryMatchContains = true;
        autocomp.highlightClassName = "YUIAutcompleteHighlight";
        autocomp.prehighlightClassName = "YUIAutcompletePreHighlight";
        document.findElementById(id + "_container").style.position = "absolute";
        document.findElementById(id + "_container").style.left = YAHOO.util.Dom.getX(document.findElementById(id)) + "px";
        document.findElementById(id + "_container").style.top = document.findElementById(id).offsetHeight + YAHOO.util.Dom.getY(document.findElementById(id)) + "px";
        document.findElementById(id + "_container").style.width = document.findElementById(id).clientWidth + "px";
    }
    
    if (document.findElementById(controlId))
        createAutocomplete(controlId, serviceUrl);
    var i = 0;
    while (document.findElementById(controlId + "_" + (++i)))
        createAutocomplete(controlId + "_" + i, serviceUrl);
}



