import { qsa } from '../core/dom.js';

/**
 * Initializes all accordions. Ensures only one `<details>` element can be open
 * at a time — both on load and at runtime when the user toggles items.
 *
 * @example
 * ```html
 * <div data-accordion>
 *   <details>
 *     <summary>Question 1</summary>
 *     <div>Answer</div>
 *   </details>
 *   <details>
 *     <summary>Question 2</summary>
 *     <div>Answer</div>
 *   </details>
 * </div>
 * ```
 */
export function initAccordions(): void {
  qsa<HTMLElement>( '[data-accordion]' ).forEach( ( accordion ) => {
    const items = qsa<HTMLDetailsElement>( 'details', accordion );

    // On load: if multiple items are somehow open (e.g. authored that way),
    // keep only the first and close the rest.
    let foundOpen = false;
    items.forEach( ( item ) => {
      if ( item.open ) {
        if ( foundOpen ) {
          item.open = false;
        } else {
          foundOpen = true;
        }
      }
    } );

    // Runtime: when any item opens, close all its siblings.
    items.forEach( ( item ) => {
      item.addEventListener( 'toggle', () => {
        if ( !item.open ) return;

        items.forEach( ( other ) => {
          if ( other !== item && other.open ) {
            other.open = false;
          }
        } );
      } );
    } );
  } );
}