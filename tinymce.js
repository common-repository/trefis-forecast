function tf_forecast_init() {
	function initDropdown(s, txt) {
		$(s).find('option').remove();
		$(s).find('optgroup').remove();
		if (txt) $(s).append($("<option/>").text(txt));
	}
	tinyMCEPopup.resizeToInnerSize();
	var tf = {
	    status: function(data, status) {
		// sometimes jsonp leaves status undefined
		return (status=="success" || status === undefined)?(data==null?"nulldata":data.status):status;
	    }
	}
	function dehydrateIdentifier(id) {
		var idx = id.indexOf(".");
		return (idx==-1|| idx+1==id.length)?id:id.substr(idx+1);
	}
	function setMessage(msg,loading) {
	    $("#tf_message").text(msg);
	    $("#loading").toggle(loading==1);
	}
	function errorHandler(xmlHttpRequest, textStatus, errorThrown) {
		setMessage("Error getting data!");
	}
	function companyHandler(data, status) {
	    if (tf.status(data,status) == "success") {
		initDropdown('#driver');
		initDropdown('#division');
	    initDropdown('#company', 'Pick a company');
		$.each(data.companies, function(key, value)
		       {   
			   $('#company').append($("<option/>").
				      attr("value",value.symbol).
				      text(value.name)); 
		       });
		setMessage("Please select a company.");
	    } else {
		setMessage("Error: " + tf.status(data,status));
	    }
	}
	function divisionHandler(data, status) {
	    if (tf.status(data,status) == "success") {
	    initDropdown('#driver');
	    initDropdown('#division', 'Pick a division');
		$.each(data.divisions, function(key, value)
		       {   
			   $('#division').append($("<option/>").
				      attr("value",value.id).
				      text(value.n)); 
		       });
		setMessage("Please select a division.");
	    } else {
		setMessage("Error: " + tf.status(data,status));
	    }
	}
	function isTop(el) {return el.t;}
	function makeOptGroup(name, drivers) {
		var group = $("<optgroup label='"+name +"'/>");
		$.each(drivers, function(key, value)
				       {
			group.append($("<option/>").
					attr("value",value.id).
					text(value.n)); 
				       });
		return group;
	}
	function driverHandler(data, status) {
	    if (tf.status(data,status) == "success") {
	    	initDropdown('#driver', 'Pick a driver');
			var topForecasts = [],
			nonTop = [];
			$.each(data.drivers,function(i,x) {
				if (isTop(x))
					topForecasts.push(x);
				else
					nonTop.push(x);
			})
			if (topForecasts.length>0)
				$('#driver').append(makeOptGroup("Top Forecasts", topForecasts))
			if (nonTop.length>0)
				$('#driver').append(makeOptGroup("All Forecasts", nonTop))
			$("#driver:selected").removeAttr("selected");
			setMessage(data.drivers.length > 0?"Please select a driver.":"Error: no drivers found");
	    } else {
	    	setMessage("Error: " + tf.status(data,status));
	    }
	}
	function insertForecastWidget() {
		var tagtext = '[trefis_forecast ticker="' + $("#company").val() + '" driver="' + dehydrateIdentifier($("#driver").val())
		+($("#width").val()==350?"":'" width="'+$("#width").val())
		+'"]';
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
		return false;
	}
	$("#insert").click(insertForecastWidget);
	$("#cancel").click(function() {
		tinyMCEPopup.close();
		return false;
	});
	function ajaxCall(endpoint, data, callback) {
		data.widgetType = 'tinymce';
		$.ajax({
			url: getTrefisContext()+endpoint,
			    data: data,
			    dataType: "jsonp",
			    success: callback,
			    error: errorHandler
		       });
	}
	
	// add listeners to the selects
	$('#company').change(function () {
		setMessage("Downloading divisions...",1);
		ajaxCall("/servlet/HtmlService/divisions", {s:$(this).val()}, divisionHandler)
	    });
	function downloadDrivers() {
		setMessage("Downloading drivers...",1)
		ajaxCall("/servlet/HtmlService/drivers", {d:$('#division').val()}, driverHandler)
	}
	
	$('#division').change(downloadDrivers);
	$('#driver').change(function () {
		setMessage("Click Insert to finish!")
    });

	// kick off an RPC to get info from trefis
	ajaxCall("/servlet/HtmlService/sectorCompanies", {}, companyHandler)
}

// Jquery will execute tf_forecast_init after javascript is loaded.
$(tf_forecast_init);
