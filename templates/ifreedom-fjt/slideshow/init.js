        window.addEvent('domready', function () {
            alert('hello Work');
            $("#open-help").click(function(e){
                alert("yeah");
                e.preventDefault();
                $("#overlay").show();
            });
            // initialize Nivoo-Slider
				if ($('Slider')) new NivooSlider($('Slider'), {
				effect: 'random',
				interval: 5000,
				orientation: 'random'
			});
        }); 
        
