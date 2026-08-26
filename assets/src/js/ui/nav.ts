import { qs } from "../core/dom.js";
import { lockScroll,unlockScroll } from "../utils/scroll-lock.js";
import { focusFirst,restoreFocus,storeFocus,trapFocus } from "../utils/focus.js";

/**
 * Initialize the page's responsive navigation.
 *
 * @example
 * ```html
 * <button
 *   data-nav-toggle
 *   aria-expanded="false"
 *   aria-controls="site-nav"
 * >
 *  Toggle Menu
 * </button>
 *
 * <nav id="site-nav" data-nav-panel hidden>
 *  ... nav items go here
 * </nav>
 * ```
 *
 * @param root
 */
export function initNav( root: HTMLElement = document.body ) {
  const toggle = qs<HTMLButtonElement>( '[data-nav-toggle]',root );
  const panel = qs<HTMLElement>( '[data-nav-panel]',root );

  if ( !toggle || !panel ) return;

  let lastFocused: HTMLElement | null = null;

  const open = () => {
    lastFocused = storeFocus();

    panel.hidden = false;
    toggle.setAttribute( 'aria-expanded','true' );
    lockScroll();
    focusFirst( panel );

    document.addEventListener( 'keydown',onKeydown );
  }

  const close = () => {
    panel.hidden = true;
    toggle.setAttribute( 'aria-expanded','false' );

    unlockScroll();
    restoreFocus( lastFocused );

    document.removeEventListener( 'keydown',onKeydown );
  }

  const onKeydown = ( event: KeyboardEvent ) => {
    if ( event.key === 'Escape' ) {
      close();
      return;
    }

    trapFocus( panel,event );
  }

  toggle.addEventListener( 'click',() => {
    const expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
    expanded ? close() : open();
  } )
}