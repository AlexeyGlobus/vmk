<template>
  <div class="map-wrap">
    <div class="bing-map">
      <bing-map
        :credentials="apiKey"
        ref="bingMap"
        id="bingMap"
        @click.shift.prevent.native="handle"
      >
      </bing-map>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PlaceOnTheMap',
  props: {
    place: Object
  },
  data: function(){
    return {
      mapInstance: null,
      pushpinInstance: null,
      apiKey: `${process.env.MIX_BING_MAPS_API_KEY}`,
      mapOptions: {
        credentials: `${process.env.MIX_BING_MAPS_API_KEY}`, 
        zoom: 17,
        center: {
          latitude: `${process.env.MIX_BING_MAP_CENTER_LAT}`, 
          longitude: `${process.env.MIX_BING_MAP_CENTER_LNG}`
        },
        mapTypeId: 'a',
        showMapTypeSelector: false,
        showScalebar: false,
        showTermsLink: false,
        showLocateMeButton: false,
        showZoomButtons: false
      }
    };
  },
  methods: {
    handle(e) {
        let point = new Microsoft.Maps.Point(e.x, e.y);
        let loc = this.mapInstance.tryPixelToLocation(point, Microsoft.Maps.PixelReference.page);
        if (typeof loc !== 'undefined' && !isNaN(loc.latitude) && !isNaN(loc.longitude)) {
          this.place.lat = loc.latitude;
          this.place.lng = loc.longitude;
          this.movePushpin();
        }       
    },
    movePushpin() {
      if (!!this.pushpinInstance) {
        this.mapInstance.entities.remove(this.pushpinInstance);
      }
      if (!isNaN(this.place.lat) && !isNaN(this.place.lng)) {
        let point = new Microsoft.Maps.Location(this.place.lat, this.place.lng);
        this.pushpinInstance = new Microsoft.Maps.Pushpin(point, {
          title: this.place.name,
          subTitle: 'City Center',
          text: '1',
          visible: true
        });
        this.mapInstance.entities.push(this.pushpinInstance);
      } 
    }
  },
  mounted() {
    setTimeout(() => {
        if (!isNaN(this.place.lat) && !isNaN(this.place.lng)) {
          this.mapOptions.center = {
            latitude: this.place.lat, 
            longitude: this.place.lng  
          }
        }
        console.log(this.mapOptions)
        this.mapInstance = new Microsoft.Maps.Map(
          document.getElementById('bingMap'), 
          this.mapOptions
        );
        this.movePushpin();
    }, 1200);
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.bing-map {
  width: 400px;
  height: 400px;
}
</style>