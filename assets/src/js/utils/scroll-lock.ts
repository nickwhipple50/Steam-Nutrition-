let scrollY = 0;
let lockCount = 0;

export function lockScroll(): void {
  if ( lockCount == 0 ) {
    scrollY = window.scrollY;

    document.body.style.position = 'fixed';
    document.body.style.top = `-${scrollY}px`;
    document.body.style.left = '0';
    document.body.style.right = '0';
    document.body.style.width = '100%';
  }

  lockCount++;
}

export function unlockScroll(): void {
  lockCount--;

  if ( lockCount > 0 ) return;

  document.body.style.position = '';
  document.body.style.top = '';
  document.body.style.left = '';
  document.body.style.right = '';
  document.body.style.width = '';

  window.scrollTo( 0,scrollY );
}