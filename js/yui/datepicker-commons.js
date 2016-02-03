function handleMouseClick(eventObj, obj)
{
    var cal = obj["calendar"].oDomContainer;
    var textField = obj["textField"];
    var mouseCoords = YAHOO.util.Event.getXY(eventObj);
    if (cal.style.display == "block" && !(mouseCoords[0] >= cal.offsetLeft && mouseCoords[0] <= cal.offsetLeft + cal.offsetWidth && mouseCoords[1] >= cal.offsetTop && mouseCoords[1] <= cal.offsetTop + cal.offsetHeight))
    {
        YAHOO.widget.Calendar.calendarIsVisible = false;
        cal.style.display = "none";
    }
    else if (mouseCoords[0] >= YAHOO.util.Dom.getX(textField) && mouseCoords[0] <= YAHOO.util.Dom.getX(textField) + textField.offsetWidth && mouseCoords[1] >= YAHOO.util.Dom.getY(textField) && mouseCoords[1] <= YAHOO.util.Dom.getY(textField) + textField.offsetHeight)
    {
        setTimeout(function()
            {
                if (!YAHOO.widget.Calendar.calendarIsVisible)
                {
                    YAHOO.widget.Calendar.calendarIsVisible = true;
                    var date = parseDate(textField.value, parseDateFormat(textField.format));
                    if (!date || isNaN(date))
                        date = new Date();
                    obj["calendar"].select((date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear());
                    obj["calendar"].cfg.setProperty("pagedate", (date.getMonth() + 1) + "/" + date.getFullYear());
                    obj["calendar"].render();
                    cal.style.left = YAHOO.util.Dom.getX(textField) + "px";
                    cal.style.top = textField.offsetHeight + YAHOO.util.Dom.getY(textField) + "px";
                    cal.style.display = "block";
                }
            }, 50);
    }
}

function handleSelect(type,args,obj) 
{
    if (obj["calendar"].oDomContainer.style.display == "none")
        return;
    var date = new Date(args[0][0][0],args[0][0][1] - 1,args[0][0][2]);
    obj["textField"].value = formatDate(date, parseDateFormat(obj["textField"].format));
    
    setTimeout(function()
        {
            YAHOO.widget.Calendar.calendarIsVisible = false;
            obj["calendar"].oDomContainer.style.display = "none";
        }, 100);
}

function handleKeypress(eventObj, obj)
{
	if (eventObj.keyCode == 27)
	{
        YAHOO.widget.Calendar.calendarIsVisible = false;
        obj["calendar"].oDomContainer.style.display = "none";
	}
}

function generateDatePicker(textBoxId, format, themeName) 
{
    //var format = "ShortDate";
    var calDiv = document.findElementById(textBoxId + "_CalendarContainer");
    if (calDiv)
        calDiv.parentNode.removeChild(calDiv);
    calDiv = document.createElement("div");
    calDiv.id = textBoxId + "_CalendarContainer";
    calDiv.className = "yui-calcontainer"+(themeName?themeName:"")+" single ";
    var sourceField = document.findElementById(textBoxId);
    document.findElementById(textBoxId).format = format;
    calDiv.style.display = "none";
    calDiv.style.position = "absolute";
    calDiv.style.fontFamily = "Arial, sans-serif";
    calDiv.style.fontStyle = "normal";
    calDiv.style.fontVariant = "normal";
    calDiv.style.fontWeight = "400";
    calDiv.style.fontSize = "13px";
    calDiv.style.lineHeight = "normal";
    calDiv.style.zIndex = "500";
    document.body.appendChild(calDiv);
    var calendar = new YAHOO.widget.Calendar(textBoxId + "_CalendarContainer",  {start_weekday:getLocaleInfo("firstWeekDay")});
    calendar.cfg.setProperty("MONTHS_SHORT", listShortMonths);
    calendar.cfg.setProperty("MONTHS_LONG", listMonths);
    calendar.cfg.setProperty("WEEKDAYS_SHORT", listShortWeekdays);
    calendar.cfg.setProperty("WEEKDAYS_MEDIUM", listShortWeekdays);
    calendar.cfg.setProperty("WEEKDAYS_LONG", listWeekdays);
    calendar.selectEvent.subscribe(handleSelect,{calendar:calendar, textField:document.findElementById(textBoxId)}, true);
    calendar.render();
    YAHOO.util.Event.addListener(document, "mousedown", handleMouseClick, {calendar:calendar, textField:document.findElementById(textBoxId)});
    YAHOO.util.Event.addListener(document, "keypress", handleKeypress, {calendar:calendar, textField:document.findElementById(textBoxId)});
}
