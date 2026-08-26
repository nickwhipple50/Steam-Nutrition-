import Swiper from "swiper";
import { A11y,Autoplay,Keyboard,Navigation,Pagination } from "swiper/modules";

import { qs,qsa } from '../core/dom.js';
import { dataBool,dataInt,dataStr } from "../core/data.js";

/**
 * Initializes all Swiper instances on the page.
 *
 * @example
 * ```html
 * <div class='swiper'
 *   data-slider-navigation="true"
 *   data-slider-pagination="true"
 *   data-slider-pagination-type="bullets"
 *   data-slider-autoplay="true"
 *   data-slider-autoplay-delay="5000"
 *   data-slider-pause-on-hover="true"
 *   data-slider-loop="true"
 *   data-slider-keyboard="true"
 *   data-slider-slides-per-view="3"
 *   data-slider-space-between="20"
 *   data-slider-centered="false"
 *   data-slider-speed="400"
 *   data-slider-grab-cursor="true"
 * >
 *   <div class='swiper-wrapper'>
 *     <div class='swiper-slide'>Slide 1</div>
 *     <div class='swiper-slide'>Slide 2</div>
 *     <div class='swiper-slide'>Slide 3</div>
 *     <div class='swiper-slide'>Slide 4</div>
 *   </div>
 *   <button class="swiper-button-prev"></button>
 *   <button class="swiper-button-next"></button>
 *   <div class="swiper-pagination"></div>
 * </div>
 * ```
 */
export function initSliders(): Swiper[] {
  const instances: Swiper[] = [];

  qsa<HTMLElement>( '.swiper' ).forEach( ( element ) => {
    if ( element.dataset.swiperInitialized === 'true' ) return;

    const wrapper = qs( '.swiper-wrapper',element );
    const slides = qsa( '.swiper-slide',element );

    if ( !wrapper || slides.length === 0 ) {
      console.warn( 'Swiper: Invalid structure',element );
      return;
    }

    try {
      // Navigation
      const navigationEnabled = dataBool( element,'sliderNavigation' );
      const prev = qs<HTMLButtonElement>( 'button.swiper-button-prev',element );
      const next = qs<HTMLButtonElement>( 'button.swiper-button-next',element );
      const hasValidNavigation = navigationEnabled && prev && next;

      // Pagination
      const paginationEnabled = dataBool( element,'sliderPagination' );
      const paginationEl = qs<HTMLElement>( '.swiper-pagination',element );
      const paginationTypeRaw = dataStr( element,'sliderPaginationType','bullets' );
      const paginationType: 'bullets' | 'fraction' | 'progressbar' | 'custom' =
        ['bullets','fraction','progressbar','custom'].includes( paginationTypeRaw )
          ? paginationTypeRaw as 'bullets' | 'fraction' | 'progressbar' | 'custom'
          : 'bullets';

      // Autoplay
      const autoplayEnabled = dataBool( element,'sliderAutoplay' );
      const autoplayDelay = dataInt( element,'sliderAutoplayDelay',3000 );
      const pauseOnHover = dataBool( element,'sliderPauseOnHover',true );

      // Slides configuration
      const slidesPerView = dataInt( element,'sliderSlidesPerView',1 );
      const spaceBetween = dataInt( element,'sliderSpaceBetween',0 );
      const centeredSlides = dataBool( element,'sliderCentered' );

      // Behavior
      const loop = dataBool( element,'sliderLoop' );
      const speed = dataInt( element,'sliderSpeed',300 );
      const keyboardEnabled = dataBool( element,'sliderKeyboard' );
      const grabCursor = dataBool( element,'sliderGrabCursor',true );

      // Only activate needed modules
      const modules = [A11y];
      if ( hasValidNavigation ) modules.push( Navigation );
      if ( paginationEnabled && paginationEl ) modules.push( Pagination );
      if ( autoplayEnabled ) modules.push( Autoplay );
      if ( keyboardEnabled ) modules.push( Keyboard );

      const swiper = new Swiper( element,{
        modules,

        // Layout
        slidesPerView,
        spaceBetween,
        centeredSlides,

        // Behavior
        loop,
        speed,
        grabCursor,
        watchOverflow: true,

        navigation: hasValidNavigation ? {
          prevEl: prev,
          nextEl: next,
        } : false,

        pagination: paginationEnabled && paginationEl ? {
          el: paginationEl,
          type: paginationType,
          clickable: true,
        } : false,

        autoplay: autoplayEnabled ? {
          delay: autoplayDelay,
          disableOnInteraction: false,
          pauseOnMouseEnter: pauseOnHover,
        } : false,

        keyboard: keyboardEnabled ? {
          enabled: true,
          onlyInViewport: true,
        } : false,

        a11y: {
          enabled: true,
          prevSlideMessage: 'Previous slide',
          nextSlideMessage: 'Next slide',
          firstSlideMessage: 'This is the first slide',
          lastSlideMessage: 'This is the last slide',
          paginationBulletMessage: 'Go to slide {{index}}',
        },

        on: {
          init: function () {
            element.dataset.swiperInitialized = 'true';
          },
          beforeDestroy: function () {
            delete element.dataset.swiperInitialized;
          }
        }
      } );

      instances.push( swiper );

    } catch ( error ) {
      console.error( 'Swiper: Failed to initialize',element,error );
    }
  } );

  return instances;
}