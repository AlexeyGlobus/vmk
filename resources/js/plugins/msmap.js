    const MSMap = {
        
        EarthRadius: 6378137,  
        MinLatitude: -85.05112878,  
        MaxLatitude: 85.05112878,  
        MinLongitude: -180,  
        MaxLongitude: 180,

        /// Clips a number to the specified minimum and maximum values.  

        /// <param name="n">The number to clip.</param>  
        /// <param name="minValue">Minimum allowable value.</param>  
        /// <param name="maxValue">Maximum allowable value.</param>  
        /// <returns>The clipped value.</returns>
        Clip(n, minValue, maxValue)
        {  
            return Math.min(Math.max(n, minValue), maxValue);  
        },
        
        /// Determines the map width and height (in pixels) at a specified level  
        /// of detail.  

        /// <param name="levelOfDetail">Level of detail, from 1 (lowest detail)  
        /// to 23 (highest detail).</param>  
        /// <returns>The map width and height in pixels.</returns>
        MapSize(levelOfDetail)
        {  
            return 256 << levelOfDetail;  
        },

        /// Determines the ground resolution (in meters per pixel) at a specified  
        /// latitude and level of detail.  
 
        /// <param name="latitude">Latitude (in degrees) at which to measure the  
        /// ground resolution.</param>  
        /// <param name="levelOfDetail">Level of detail, from 1 (lowest detail)  
        /// to 23 (highest detail).</param>  
        /// <returns>The ground resolution, in meters per pixel.</returns>  
        GroundResolution(lat, levelOfDetail)  
        {  
            let latitude = this.Clip(lat, MinLatitude, MaxLatitude);  
            return Math.cos(latitude * Math.PI / 180) * 2 * Math.PI * this.EarthRadius / this.MapSize(levelOfDetail);  
        },

        /// Determines the map scale at a specified latitude, level of detail,  
        /// and screen resolution.  
 
        /// <param name="latitude">Latitude (in degrees) at which to measure the  
        /// map scale.</param>  
        /// <param name="levelOfDetail">Level of detail, from 1 (lowest detail)  
        /// to 23 (highest detail).</param>  
        /// <param name="screenDpi">Resolution of the screen, in dots per inch.</param>  
        /// <returns>The map scale, expressed as the denominator N of the ratio 1 : N.</returns>  
        MapScale(latitude, levelOfDetail, screenDpi)  
        {  
            return this.GroundResolution(latitude, levelOfDetail) * screenDpi / 0.0254;  
        },

        /// Converts a point from latitude/longitude WGS-84 coordinates (in degrees)  
        /// into pixel XY coordinates at a specified level of detail.  
 
        /// <param name="lat">Latitude of the point, in degrees.</param>  
        /// <param name="lon">Longitude of the point, in degrees.</param>  
        /// <param name="levelOfDetail">Level of detail, from 1 (lowest detail)  
        /// to 23 (highest detail).</param>  
        /// <param name="pixelX">Output parameter receiving the X coordinate in pixels.</param>  
        /// <param name="pixelY">Output parameter receiving the Y coordinate in pixels.</param>  
        LatLongToPixelXY(lat, lon, levelOfDetail)  
        {  
            let latitude = this.Clip(lat, MinLatitude, MaxLatitude);  
            let longitude = this.Clip(lon, MinLongitude, MaxLongitude);  
  
            let x = (longitude + 180) / 360;   
            let sinLatitude = Math.sin(latitude * Math.PI / 180);  
            let y = 0.5 - Math.log((1 + sinLatitude) / (1 - sinLatitude)) / (4 * Math.PI);  
  
            let mapSize = this.MapSize(levelOfDetail);  
            let pixelX = this.Clip(x * mapSize + 0.5, 0, mapSize - 1);  
            let pixelY = this.Clip(y * mapSize + 0.5, 0, mapSize - 1);
            return [pixelX, pixelY];
        },

        /// Converts a pixel from pixel XY coordinates at a specified level of detail  
        /// into latitude/longitude WGS-84 coordinates (in degrees).  
 
        /// <param name="pixelX">X coordinate of the point, in pixels.</param>  
        /// <param name="pixelY">Y coordinates of the point, in pixels.</param>  
        /// <param name="levelOfDetail">Level of detail, from 1 (lowest detail)  
        /// to 23 (highest detail).</param>  
        /// <param name="latitude">Output parameter receiving the latitude in degrees.</param>  
        /// <param name="longitude">Output parameter receiving the longitude in degrees.</param>  
        PixelXYToLatLong(pixelX, pixelY, levelOfDetail)  
        {  
            let mapSize = this.MapSize(levelOfDetail); 
            mapSize = 400; 
            let x = (this.Clip(pixelX, 0, mapSize - 1) / mapSize) - 0.5;  
            let y = 0.5 - (this.Clip(pixelY, 0, mapSize - 1) / mapSize);  

            console.log(x)
            console.log(y)
  
            let latitude = 90 - 360 * Math.atan(Math.exp(-y * 2 * Math.PI)) / Math.PI;  
            let longitude = 360 * x; 
            return {latitude: latitude, longitude: longitude}; 
        },

        /// Converts pixel XY coordinates into tile XY coordinates of the tile containing  
        /// the specified pixel.  
  
        /// <param name="pixelX">Pixel X coordinate.</param>  
        /// <param name="pixelY">Pixel Y coordinate.</param>  
        /// <param name="tileX">Output parameter receiving the tile X coordinate.</param>  
        /// <param name="tileY">Output parameter receiving the tile Y coordinate.</param>  
        PixelXYToTileXY(pixelX, pixelY)  
        {  
            let tileX = pixelX / 256;  
            let tileY = pixelY / 256;
            return [tileX, tileY];
        },

        /// Converts tile XY coordinates into pixel XY coordinates of the upper-left pixel  
        /// of the specified tile.  
 
        /// <param name="tileX">Tile X coordinate.</param>  
        /// <param name="tileY">Tile Y coordinate.</param>  
        /// <param name="pixelX">Output parameter receiving the pixel X coordinate.</param>  
        /// <param name="pixelY">Output parameter receiving the pixel Y coordinate.</param>  
        TileXYToPixelXY(tileX, tileY)  
        {  
            let pixelX = tileX * 256;  
            let pixelY = tileY * 256;
            return [pixelX, pixelY];  
        },

        /// Converts tile XY coordinates into a QuadKey at a specified level of detail.  
 
        /// <param name="tileX">Tile X coordinate.</param>  
        /// <param name="tileY">Tile Y coordinate.</param>  
        /// <param name="levelOfDetail">Level of detail, from 1 (lowest detail)  
        /// to 23 (highest detail).</param>  
        /// <returns>A string containing the QuadKey.</returns>  
        TileXYToQuadKey(tileX, tileY, levelOfDetail)  
        {  
            let quadKey;  
            for (let i = levelOfDetail; i > 0; i--)  
            {  
                let digit = 0;  
                let mask = 1 << (i - 1);  
                if ((tileX & mask) != 0)  
                {  
                    digit++;  
                }  
                if ((tileY & mask) != 0)  
                {  
                    digit++;  
                    digit++;  
                }  
                quadKey = '' + quadKey + digit;  
            }  
            return quadKey;  
        },

        /// Converts a QuadKey into tile XY coordinates.  
  
        /// <param name="quadKey">QuadKey of the tile.</param>  
        /// <param name="tileX">Output parameter receiving the tile X coordinate.</param>  
        /// <param name="tileY">Output parameter receiving the tile Y coordinate.</param>  
        /// <param name="levelOfDetail">Output parameter receiving the level of detail.</param>  
        QuadKeyToTileXY(quadKey)  
        {  
            let tileX = 0;
            let tileY = 0;  
            let levelOfDetail = quadKey.length;  
            for (let i = levelOfDetail; i > 0; i--)  
            {  
                let mask = 1 << (i - 1);  
                switch (quadKey[levelOfDetail - i])  
                {  
                    case '0':  
                        break;  
  
                    case '1':  
                        tileX |= mask;  
                        break;  
  
                    case '2':  
                        tileY |= mask;  
                        break;  
  
                    case '3':  
                        tileX |= mask;  
                        tileY |= mask;  
                        break; 
                }  
            }
            return {tileX: tileX, tileY: tileY, levelOfDetail: levelOfDetail}; 
        },
    }

    export default {MSMap}  