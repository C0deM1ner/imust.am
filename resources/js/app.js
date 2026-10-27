import '@phosphor-icons/web/regular';
import '@phosphor-icons/web/light';

import mobileMenu from './components/mobileMenu';
import header from './components/header';
import reveal from './components/reveal';
import gallery from './components/gallery';
import copyLink from './components/copyLink';
import languageMenu from './components/languageMenu';
import contactForm from './components/contactForm';

// The mobile menu goes first so nothing further down can stop it from working.
mobileMenu();
header();
reveal();
gallery();
copyLink();
languageMenu();
contactForm();
