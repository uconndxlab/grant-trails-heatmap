async getCoordinates({ commit }) {
    let { data: zipCodes, error } = await supabase
      .from("purchases")
      .select("Zip", "id");
    if (error) throw error;

    let coordinates = [];

    const mapBoxToken = process.env.VUE_APP_MAPBOX_ACCESS_TOKEN;
    for await (const zipCode of zipCodes) {
      if (zipCode.Zip) {
        const response = await fetch(
          `https://api.mapbox.com/geocoding/v5/mapbox.places/${zipCode.Zip}.json?access_token=${mapBoxToken}&limit=1`
        );
        const data = await response.json();
        const coordinatesAndZip = [];
        try {
          coordinatesAndZip.push(
            zipCode.id,
            data.features[0].geometry.coordinates
          );
        } catch (err) {
          console.log(err);
        }
        coordinates.push(coordinatesAndZip);
        console.log("Got coords!");
      }
    }
    console.log(coordinates);
    console.log("uploading");

    for (const coordinate of coordinates) {
      await supabase
        .from("purchases")
        .update({
          Location: coordinate[1],
        })
        .eq("id", coordinate[0]);
    }
    console.log("done updating!");