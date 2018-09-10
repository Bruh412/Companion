<style>
    .gllpMap {
	margin-top: 20px;
    min-width: 400px;
    max-width: 2000px;
    min-height: 400px;
    max-height: 400px;
}
</style>

@extends('layouts.admin')

@section('content')

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDpz7JmYU3-2CsRVbv3JHKzP-vdzkhgCrY&amp;sensor=false&amp;libraries=places"></script>
<script>
		/**
	*
	* A JQUERY GOOGLE MAPS LATITUDE AND LONGITUDE LOCATION PICKER
	* version 1.2
	*
	* Supports multiple maps. Works on touchscreen. Easy to customize markup and CSS.
	*
	* To see a live demo, go to:
	* http://www.wimagguc.com/projects/jquery-latitude-longitude-picker-gmaps/
	*
	* by Richard Dancsi
	* http://www.wimagguc.com/
	*
	*/

	(function($) {

	// for ie9 doesn't support debug console >>>
	if (!window.console) window.console = {};
	if (!window.console.log) window.console.log = function () { };
	// ^^^

	$.fn.gMapsLatLonPicker = (function() {

		var _self = this;

		///////////////////////////////////////////////////////////////////////////////////////////////
		// PARAMETERS (MODIFY THIS PART) //////////////////////////////////////////////////////////////
		_self.params = {
			defLat : 0,
			defLng : 0,
			defZoom : 1,
			queryLocationNameWhenLatLngChanges: true,
			queryElevationWhenLatLngChanges: true,
			mapOptions : {
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControl: false,
				disableDoubleClickZoom: true,
				zoomControlOptions: true,
				streetViewControl: true,
				fullscreenControl: false,
				styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#55b3fe"},{"visibility":"on"}]}]
			},
			strings : {
				markerText : "Drag this Marker",
				error_empty_field : "Couldn't find coordinates for this place",
				error_no_results : "Couldn't find coordinates for this place"
			},
			displayError : function(message) {
				alert(message);
			}
		};


		///////////////////////////////////////////////////////////////////////////////////////////////
		// VARIABLES USED BY THE FUNCTION (DON'T MODIFY THIS PART) ////////////////////////////////////
		_self.vars = {
			ID : null,
			LATLNG : null,
			map : null,
			marker : null,
			geocoder : null
		};

		///////////////////////////////////////////////////////////////////////////////////////////////
		// PRIVATE FUNCTIONS FOR MANIPULATING DATA ////////////////////////////////////////////////////
		var setPosition = function(position) {
			_self.vars.marker.setPosition(position);
			_self.vars.map.panTo(position);

			$(_self.vars.cssID + ".gllpZoom").val( _self.vars.map.getZoom() );
			$(_self.vars.cssID + ".gllpLongitude").val( position.lng() );
			$(_self.vars.cssID + ".gllpLatitude").val( position.lat() );

			$(_self.vars.cssID).trigger("location_changed", $(_self.vars.cssID));

			if (_self.params.queryLocationNameWhenLatLngChanges) {
				getLocationName(position);
			}
			if (_self.params.queryElevationWhenLatLngChanges) {
				getElevation(position);
			}
		};

		// for reverse geocoding
		var getLocationName = function(position) {
			var latlng = new google.maps.LatLng(position.lat(), position.lng());
			_self.vars.geocoder.geocode({'latLng': latlng}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK && results[1]) {
					$(_self.vars.cssID + ".gllpLocationName").val(results[1].formatted_address);
					$(_self.vars.cssID + ".gllpSearchField").val(results[1].formatted_address);
				} else {
					$(_self.vars.cssID + ".gllpLocationName").val("");
				}
				$(_self.vars.cssID).trigger("location_name_changed", $(_self.vars.cssID));
			});
		};

		// for getting the elevation value for a position
		var getElevation = function(position) {
			var latlng = new google.maps.LatLng(position.lat(), position.lng());

			var locations = [latlng];

			var positionalRequest = { 'locations': locations };

			_self.vars.elevator.getElevationForLocations(positionalRequest, function(results, status) {
				if (status == google.maps.ElevationStatus.OK) {
					if (results[0]) {
						$(_self.vars.cssID + ".gllpElevation").val( results[0].elevation.toFixed(3));
					} else {
						$(_self.vars.cssID + ".gllpElevation").val("");
					}
				} else {
					$(_self.vars.cssID + ".gllpElevation").val("");
				}
				$(_self.vars.cssID).trigger("elevation_changed", $(_self.vars.cssID));
			});
		};

		// search function
		var performSearch = function(string, silent) {
			if (string == "") {
				if (!silent) {
					_self.params.displayError( _self.params.strings.error_empty_field );
				}
				return;
			}
			_self.vars.geocoder.geocode(
				{"address": string},
				function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						$(_self.vars.cssID + ".gllpZoom").val(11);
						_self.vars.map.setZoom( parseInt($(_self.vars.cssID + ".gllpZoom").val()) );
						setPosition( results[0].geometry.location );
					} else {
						if (!silent) {
							_self.params.displayError( _self.params.strings.error_no_results );
						}
					}
				}
			);
		};

		///////////////////////////////////////////////////////////////////////////////////////////////
		// PUBLIC FUNCTIONS  //////////////////////////////////////////////////////////////////////////
		var publicfunc = {

			getLongLat : function(){
				if ("geolocation" in navigator){
					navigator.geolocation.getCurrentPosition(function(position){ 
						_self.params.defLat = position.coords.latitude;
						_self.params.defLng = position.coords.longitude;
					});
				}
			},
			
			setCenterZoom: function(object,lng,lat){
				var latlng = new google.maps.LatLng(lat, lng);
				_self.vars.map.setZoom(_self.params.defZoom);
				setPosition(latlng);
			},

			// INITIALIZE MAP ON DIV //////////////////////////////////////////////////////////////////
			init : function(object) {

				if ( !$(object).attr("id") ) {
					if ( $(object).attr("name") ) {
						$(object).attr("id", $(object).attr("name") );
					} else {
						$(object).attr("id", "_MAP_" + Math.ceil(Math.random() * 10000) );
					}
				}


				_self.vars.ID = $(object).attr("id");
				_self.vars.cssID = "#" + _self.vars.ID + " ";

				this.getLongLat();

				_self.params.defLat  = $(_self.vars.cssID + ".gllpLatitude").val()  ? $(_self.vars.cssID + ".gllpLatitude").val()		: _self.params.defLat;
				_self.params.defLng  = $(_self.vars.cssID + ".gllpLongitude").val() ? $(_self.vars.cssID + ".gllpLongitude").val()	    : _self.params.defLng;
				_self.params.defZoom = $(_self.vars.cssID + ".gllpZoom").val()      ? parseInt($(_self.vars.cssID + ".gllpZoom").val()) : _self.params.defZoom;

				_self.vars.LATLNG = new google.maps.LatLng(_self.params.defLat, _self.params.defLng);

				_self.vars.MAPOPTIONS		 = _self.params.mapOptions;
				_self.vars.MAPOPTIONS.zoom   = _self.params.defZoom;
				_self.vars.MAPOPTIONS.center = _self.vars.LATLNG;

				_self.vars.map = new google.maps.Map($(_self.vars.cssID + ".gllpMap").get(0), _self.vars.MAPOPTIONS);
				_self.vars.geocoder = new google.maps.Geocoder();
				_self.vars.elevator = new google.maps.ElevationService();


				// putting the current to the address input field
				var latlng = new google.maps.LatLng(_self.params.defLat, _self.params.defLng);
				_self.vars.geocoder.geocode({'latLng': latlng}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK && results[1]) {
						$(_self.vars.cssID + ".gllpLocationName").val(results[1].formatted_address);
						$(_self.vars.cssID + ".gllpSearchField").val(results[1].formatted_address);
					} else {
						console.log(" , , , a.sdasd asd as");
						$(_self.vars.cssID + ".gllpLocationName").val("");
					}
					$(_self.vars.cssID).trigger("location_name_changed", $(_self.vars.cssID));
				});


				_self.vars.marker = new google.maps.Marker({
					position: _self.vars.LATLNG,
					map: _self.vars.map,
					title: _self.params.strings.markerText,
					draggable: true
				});
				/////////////////////////////////////////////////////////////////////////////////////////////////////////
				// CUSTOM CODE FOR AUTOCOMPLETE

				var input = document.getElementById('searchfield');
				var autocomplete = new google.maps.places.Autocomplete(input);
				autocomplete.bindTo('bounds', _self.vars.map);

				var infowindow = new google.maps.InfoWindow();
				var marker = new google.maps.Marker({
					map: _self.vars.map
				});

				google.maps.event.addListener(autocomplete, 'place_changed', function() {

					infowindow.close();
					marker.setVisible(false);
					var place = autocomplete.getPlace();
					// console.log(" ghasdasdasd");
					$(_self.vars.cssID + ".gllpLongitude").val( place.geometry.location.lng() );
					$(_self.vars.cssID + ".gllpLatitude").val( place.geometry.location.lat() );
					if (!place.geometry) {
					return;
					}
							
					
					// If the place has a geometry, then present it on a map.
					if (place.geometry.viewport) {
						_self.vars.map.fitBounds(place.geometry.viewport);
					} else {
						_self.vars.map.setCenter(place.geometry.location);
						_self.vars.map.setZoom(17);  // Why 17? Because it looks good.
					}
					marker.setIcon(/** @type {google.maps.Icon} */({
						url: place.icon,
						size: new google.maps.Size(71, 71),
						origin: new google.maps.Point(0, 0),
						anchor: new google.maps.Point(17, 34),
						scaledSize: new google.maps.Size(35, 35)
					}));
					marker.setPosition(place.geometry.location);
					marker.setVisible(true);

					var address = '';
					if (place.address_components) {
						address = [
							(place.address_components[0] && place.address_components[0].short_name || ''),
							(place.address_components[1] && place.address_components[1].short_name || ''),
							(place.address_components[2] && place.address_components[2].short_name || '')
						].join(' ');
					}

					infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
					infowindow.open(_self.vars.map, marker);
				});

					

				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// end custom autocomplete




				google.maps.event.addListenerOnce(_self.vars.map, 'idle', function() {
					google.maps.event.trigger(_self.vars.map, 'resize');
					$(_self.vars.cssID).trigger("location_changed", $(_self.vars.cssID));
				});

				// Set position on doubleclick
				google.maps.event.addListener(_self.vars.map, 'dblclick', function(event) {
					setPosition(event.latLng);
					$(_self.vars.cssID).trigger("location_changed", $(_self.vars.cssID));
				});

				// Set position on marker move
				google.maps.event.addListener(_self.vars.marker, 'dragend', function(event) {
					setPosition(_self.vars.marker.position);
					$(_self.vars.cssID).trigger("location_changed", $(_self.vars.cssID));
				});

				// Set zoom feld's value when user changes zoom on the map
				google.maps.event.addListener(_self.vars.map, 'zoom_changed', function(event) {
					$(_self.vars.cssID + ".gllpZoom").val( _self.vars.map.getZoom() );
					$(_self.vars.cssID).trigger("location_changed", $(_self.vars.cssID));
				});

				// Update location and zoom values based on input field's value
				$(_self.vars.cssID + ".gllpUpdateButton").bind("click", function() {
					var lat = $(_self.vars.cssID + ".gllpLatitude").val();
					var lng = $(_self.vars.cssID + ".gllpLongitude").val();
					var latlng = new google.maps.LatLng(lat, lng);
					_self.vars.map.setZoom( parseInt( $(_self.vars.cssID + ".gllpZoom").val() ) );
					setPosition(latlng);
				});

				// Search function by search button
				$(_self.vars.cssID + ".gllpSearchButton").bind("click", function() {
					performSearch( $(_self.vars.cssID + ".gllpSearchField").val(), false );
				});

				// Search function by search button
				// $(_self.vars.cssID + ".gllpSearchField").bind("onkeypress", function() {
				// 	performSearch( $(_self.vars.cssID + ".gllpSearchField").val(), false );
				// });

				// Search function by gllp_perform_search listener
				$(document).bind("gllp_perform_search", function(event, object) {
					performSearch( $(object).attr('string'), true );
				});

				// Zoom function triggered by gllp_perform_zoom listener
				$(document).bind("gllp_update_fields", function(event) {
					var lat = $(_self.vars.cssID + ".gllpLatitude").val();
					var lng = $(_self.vars.cssID + ".gllpLongitude").val();
					var latlng = new google.maps.LatLng(lat, lng);
					_self.vars.map.setZoom( parseInt( $(_self.vars.cssID + ".gllpZoom").val() ) );
					setPosition(latlng);
				});
			},

			// EXPORT PARAMS TO EASILY MODIFY THEM ////////////////////////////////////////////////////
			params : _self.params

			};

		return publicfunc;
	});
		
	$(document).ready( function() {
		$obj = null;
		if (!$.gMapsLatLonPickerNoAutoInit) {
			$(".gllpLatlonPicker").each(function () {
				$obj = $(document).gMapsLatLonPicker();
				$obj.init( $(this) );
			});
		}
		
		$(".setCenterZoom").on("click",function(){
			var lng=  $(this).attr("data-lng");
			var lat = $(this).attr("data-lat");
			if($obj!=null){
				$obj.setCenterZoom($(this),lng,lat);
			}
			console.log("CLicked "+lng+" "+lat);
		});
	});

	$(document).bind("location_changed", function(event, object) {
		// console.log("changed: " + $(object).attr('id') );
	});

	}(jQuery));
</script>


<a href="/home" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
	<h1>Venues <a href="/addVenue" class="btn btn-primary"> <i class="fas fa-plus-circle"></i> Add New Venue</a></h1>
       <div class="form-group">
			<fieldset class="gllpLatlonPicker" style="max-height: 100px;">
				<!-- <div class="search-container">
					<input type="text" id="searchfield" name="location" class="gllpSearchField form-control" placeholder="Search for...">
				</div> -->
				<div class="gllpMap map-frame">Google Maps</div>
				<input type="hidden" class="gllpLatitude" name="latitude" id="latChange" value="10.289796"/>
				<input type="hidden" class="gllpLongitude" name="longitude" id="longChange" value="123.86165900000003"/>
				<input type="hidden" class="gllpZoom" value="17"/> 
			</fieldset>

            <table style="margin-top: 400px" class="table table-hover">
                <tr>
                    <th>Venue</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Category</th>
					<th colspan='2'>Options</th>
				</tr>

				@foreach($venues as $venue)
                    <tr>
                        <td>{{ $venue->venueName }}</td>
                        <td>{{ $venue->latitude }}</td>
                        <td>{{ $venue->longitude }}</td>
                        <td>{{ $venue->venueCategory }}</td>
						<td><button class="setCenterZoom btn" data-lat="{{ $venue->latitude }}" data-lng="{{ $venue->longitude }}"><abbr title="View Venue"><i class="fas fa-eye"></i></abbr></button></td>
						<td><a href="#" style="color: #636b6f;padding: 0 10px;font-size: 20px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;" data-toggle="modal" data-target="#deleteVenue{{ $venue['id'] }}"><abbr title="Delete"><i class="fas fa-trash-alt"></i></abbr></a></td>
					</tr>
					<div class="modal fade" id="deleteVenue{{ $venue['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">You are about to delete a venue!</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							Are you sure you want to delete "{{ $venue['venueName'] }}"? You cannot undo your action once it has been done.
						</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<a class="btn btn-danger" href="/deleteVenue/{{ $venue->id }}">Delete</a>
						</div>
						</div>
					</div>
					</div>
                @endforeach
            </table>
		</div>
		@if(!$venues->isEmpty())
		<div>
			{{ $venues->links() }}
		</div>
		@endif

    <br>
<script type="text/javascript">
	
</script>
@endsection

