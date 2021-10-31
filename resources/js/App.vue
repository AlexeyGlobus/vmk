<template>
    <!-- App.vue -->

<v-app>
  <v-navigation-drawer app v-if="false">
    <!-- -->
  </v-navigation-drawer>

    <v-card class="overflow-hidden">
    <v-app-bar
      absolute
      color="#6A76AB"
      dark

      dense
      src="https://picsum.photos/1920/1080?random"
      fade-img-on-scroll
      scroll-target="#scrolling-techniques-3"
    >
      <template v-slot:img="{ props }">
        <v-img
          v-bind="props"
          gradient="to top right, rgba(100,115,201,.7), rgba(25,32,72,.7)"
        ></v-img>
      </template>

      <!-- <v-app-bar-nav-icon></v-app-bar-nav-icon> -->

      <v-app-bar-title>GLOBUS</v-app-bar-title>

      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>mdi-heart</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>

      <template v-slot:extension>
        <v-tabs align-with-title>
          <v-tab
            v-for="link of links"
            :key="link.title"
            :to="link.url"
            @click.prevent=""
            exact>
            <!-- <v-icon>{{ link.icon }}</v-icon> -->
            {{ link.title }}
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>
    <v-sheet
      id="scrolling-techniques-3"
      class="overflow-y-auto"
      max-height="600"
    >
      <v-container style="height: 1000px;"></v-container>
    </v-sheet>
  </v-card>




  <!-- Sizes your content based upon application components -->
  <v-main>

    <!-- Provides the application the proper gutter -->
    <v-container fluid>
      <!-- If using vue-router -->
      <router-view></router-view>
    </v-container>
  </v-main>

  <v-footer app>
    <!-- -->
    <p>Some footer text</p>
  </v-footer>
</v-app>
</template>

<script>
	    export default {
        props: {
            source: String,
        },
        name: "Globus",
        data: () => {
            return {
                text: 'This part of application is rendered in Vue.',
                drawer: false,
                links: [
                    {title: 'Login', icon: 'mdi-lock', url: '/login'},
                    {title: 'Register', icon: 'how_to_reg', url: '/register'},
                    {title: 'Orders', icon: 'shop', url: '/orders'},
                    {title: 'New bulletin', icon: 'note_add', url: '/create'},
                    {title: 'My bulletins', icon: 'list', url: '/list'}
                ],
            }
        }
    }
</script>