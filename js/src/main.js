import '../../css/src/style.scss';
import { CookieManager } from './cookie-manager.js';

/**
 * A class the cookie notice functionality.
 */
export class CookieNotice {

    /**
     * Constructor.
     */
    constructor() {
        this.noticeContainer = $( '#wpcn_container' );
        this.cookieManager = new CookieManager();
        this.cookieName = 'wpcn_notice_accepted';
    };

    /**
     * Initializes all of the behavior for the cookie notice functionality.
     */
    init() {

        // Bind the click event for the "Accept" button
        this.bindAcceptButton();

        // If the cookie isn't set, show the notice container
        if ( ! this.cookieManager.readCookie( this.cookieName ) ) {
            this.showNotice();
        }
    }

    /**
     * Binds the click event for the "Accept" button to its handler.
     */
    bindAcceptButton() {
        let event = 'click.cookienotice',
            $acceptButton = $( '#wpcn_button_accept' );

        $acceptButton.off( event )
            .on( event, () => this.handleAcceptClick() );
    }

    /**
     * Shows the cookie notice.
     */
    showNotice() {
        this.noticeContainer.removeClass( 'd-none' );
    }

    /**
     * Hides the cookie notice.
     */
    hideNotice() {
        this.noticeContainer.addClass( 'd-none' );
    }

    /**
     * Handler for when the "Accept" button is clicked.
     * Hides the cookie notice and sets the related cookie so that the notice is not shown again.
     *
     * @param event
     */
    handleAcceptClick( event ) {
        this.hideNotice();
        this.cookieManager.createCookie( this.cookieName, true, 365 );
    }
}

let $cookieNotice = new CookieNotice();
$cookieNotice.init();
