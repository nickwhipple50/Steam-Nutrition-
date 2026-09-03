import { qs,qsa } from '../core/dom.js';

/**
 * Syncs the hero's optional thumbnail filmstrip with its Swiper background
 * slideshow: clicking a thumbnail jumps the slideshow to that slide, and
 * the active thumbnail updates as the slideshow advances (autoplay, arrows,
 * or keyboard).
 *
 * @example
 * ```html
 * <section class="hero">
 *   <div class="swiper" data-hero-swiper>...</div>
 *   <div class="hero__filmstrip" data-hero-filmstrip>
 *     <button class="filmstrip__item" data-filmstrip-index="0"></button>
 *     <button class="filmstrip__item" data-filmstrip-index="1"></button>
 *   </div>
 * </section>
 * ```
 */
export function initHero( root: HTMLElement = document.body ) {
  qsa<HTMLElement>( '[data-hero-swiper]',root ).forEach( ( swiperEl ) => {
    const hero = swiperEl.closest( '.hero' );
    if ( !hero ) return;

    const filmstrip = qs<HTMLElement>( '[data-hero-filmstrip]',hero as HTMLElement );
    if ( !filmstrip ) return;

    const items = qsa<HTMLButtonElement>( '.filmstrip__item',filmstrip );
    if ( items.length === 0 ) return;

    const setActive = ( index: number ) => {
      items.forEach( ( item,i ) => {
        item.classList.toggle( 'is-active',i === index );
      } );
    };

    items.forEach( ( item ) => {
      item.addEventListener( 'click',() => {
        const index = parseInt( item.dataset.filmstripIndex ?? '0',10 );
        const swiper = ( swiperEl as any ).swiper;

        if ( swiper ) swiper.slideToLoop( index );
        setActive( index );
      } );
    } );

    // Swiper initializes asynchronously (after slider.ts runs) — poll
    // briefly until the instance is attached, then wire the sync listener.
    let attempts = 0;
    const attachListener = () => {
      const swiper = ( swiperEl as any ).swiper;

      if ( !swiper ) {
        if ( ++attempts > 50 ) return;
        requestAnimationFrame( attachListener );
        return;
      }

      swiper.on( 'realIndexChange',() => setActive( swiper.realIndex ) );
    };

    attachListener();
  } );
}