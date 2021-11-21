<template>
  <div class="map-wrap">
    <div class="bing-map">
      <bing-map 
        :credentials="apiKey" 
        :options="mapOptions"
        ref="bingMap"
      >
        <bing-map-layer name="layer-1">
          <bing-map-pushpin v-for="item in pins" 
            :key="item.key"
            :location="item.location" 
            :options="item.options">
          </bing-map-pushpin>
        </bing-map-layer>
      </bing-map>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PlaceOnTheMap',
  props: ['place'],
  data: function(){
    return {
      apiKey: `${process.env.MIX_BING_MAPS_API_KEY}`,
      mapOptions: {
        zoom: 18,
        center: {
          latitude: parseFloat(this.place.lat), 
          longitude: parseFloat(this.place.lng)
        },
        mapTypeId: 'aerial',
        showMapTypeSelector: false,
        showScalebar: false,
        showTermsLink: false,
        showLocateMeButton: false,
        showZoomButtons: false
      },
      pins: [
        {
          key: 'pin1',
          location: {
            latitude: parseFloat(this.place.lat),
            longitude: parseFloat(this.place.lng)
          },
          options: {
            title: 'pin 1',
            visible: true
          }
        }
      ]
    };
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.bing-map {
  width: 300px;
  height: 300px;
}
</style>