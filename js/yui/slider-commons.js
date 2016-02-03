function initSlider(textBoxId, sliderLength, minValue, maxValue, step, position, sliderThumb)
{
    var mainDiv, sliderDiv, imageDiv, img, textbox = document.findElementById(textBoxId);
    img = document.createElement("img");
    img.src = sliderThumb;
    imageDiv = document.createElement("div");
    imageDiv.id = textBoxId + "_slider-thumb";
    imageDiv.className = "ccs-slider-thumb";
    imageDiv.appendChild(img);
    var bgDiv = document.createElement("div");
    sliderDiv = document.createElement("div");
    sliderDiv.id = textBoxId + "_slider-bg";
    sliderDiv.style.height = "28px";
    sliderDiv.style.top = "4px";
    sliderDiv.style.position = "relative";
    sliderDiv.tabIndex = -1;
    sliderDiv.title = "Slider";
    sliderDiv.style.width = (sliderLength + 16) + "px";
    sliderDiv.style.cssFloat = "left";
    sliderDiv.style.styleFloat = "left";
    var lBlankDiv = document.createElement("div");
    lBlankDiv.className = "ccs-slider-line-margin";
    bgDiv.appendChild(lBlankDiv);
    var sl = document.createElement("div");
    sl.className = "ccs-slider-line-l";
    bgDiv.appendChild(sl);
    var sc = document.createElement("div");
    sc.className = "ccs-slider-line-c";
    sc.style.width = (sliderLength - 2) + "px";
    bgDiv.appendChild(sc);
    var sr = document.createElement("div");
    sr.className = "ccs-slider-line-r";
    bgDiv.appendChild(sr);
    var rBlankDiv = document.createElement("div");
    rBlankDiv.className = "ccs-slider-line-margin";
    bgDiv.appendChild(rBlankDiv);
    bgDiv.style.position = "absolute";
    sliderDiv.appendChild(bgDiv);
    sliderDiv.appendChild(imageDiv);
    if (position == "before")
        textbox.parentNode.insertBefore(sliderDiv, textbox);
    else
        textbox.parentNode.insertBefore(sliderDiv, textbox.nextSibling);
    textbox.style.cssFloat = "left";
    textbox.style.styleFloat = "left";
    var pixStep = step * sliderLength / (maxValue - minValue);
    var slider = YAHOO.widget.Slider.getHorizSlider(textBoxId + "_slider-bg", textBoxId + "_slider-thumb", 0, sliderLength, pixStep);
    slider.minValue = minValue;
    slider.maxValue = maxValue;
    slider.sliderLength = sliderLength;
    slider.subscribe("change", sliderChange, {slider:slider, textField:textbox}, true);
    YAHOO.util.Event.addListener(textbox, "change", handleSliderChangeValue, {slider:slider, textField:textbox});
}

function handleSliderChangeValue(eventObj, obj)
{
    obj["slider"].setValue(obj["slider"].sliderLength * (obj["textField"].value - obj["slider"].minValue) / (obj["slider"].maxValue - obj["slider"].minValue));
}

function sliderChange(args,obj) 
{
    obj.textField.value = obj.slider.minValue + args * (obj.slider.maxValue - obj.slider.minValue) / obj.slider.sliderLength;
}
