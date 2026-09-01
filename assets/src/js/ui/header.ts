import { qs } from "../core/dom.js";

const SCROLLED_CLASS = 'site-header--scrolled';
const SCROLL_THRESHOLD = 24;

/**
 * Makes the site header transparent while idle at the top of the page,
 * and solid (brass-lined panel) once the page has scrolled past a small
 * threshold. Hovering or focusing into the header (e.g. opening a nav
 * dropdown) also forces the solid state — handled in CSS via :hover /
 * :focus-within, so no JS is needed for that part.
 *
 * @example
 * ```html
 * <header data-site-header>...</header>
 * ```
 *
 * @param root
 */
export function initHeader( root: HTMLElement = document.body ) {
  const header = qs<HTMLElement>( '[data-site-header]',root );

  if ( !header ) return;

  const setHeaderHeight = () => {
    document.documentElement.style.setProperty(
      '--header-height',
      `${header.offsetHeight}px`,
    );
  }

  const updateScrolled = () => {
    header.classList.toggle( SCROLLED_CLASS,window.scrollY > SCROLL_THRESHOLD );
  }

  setHeaderHeight();
  updateScrolled();

  window.addEventListener( 'scroll',updateScrolled,{ passive: true } );
  window.addEventListener( 'resize',setHeaderHeight );
}