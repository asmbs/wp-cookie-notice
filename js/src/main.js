import '../../css/src/style.scss';
import { CookieManager } from './cookie-manager.js';

export class CookieNotice {

    constructor() {
        this.noticeContainer = $( '#wpcn_container' );
        this.cookieManager = new CookieManager();
        this.cookieName = 'wpcn_notice_accepted';
    };

    init() {

        // Bind the click event for the "Accept" button
        this.bindAcceptButton();

        // If the cookie isn't set, show the notice container
        if ( ! this.cookieManager.readCookie( this.cookieName ) ) {
            this.showNotice();
        }
    }

    bindAcceptButton() {
        let event = 'click.cookienotice',
            $acceptButton = $( '#wpcn_button_accept' );

        $acceptButton.off( event )
            .on( event, () => this.handleAcceptClick() );
    }

    showNotice() {
        this.noticeContainer.removeClass( 'd-none' );
    }

    hideNotice() {
        this.noticeContainer.addClass( 'd-none' );
    }

    handleAcceptClick( event ) {
        this.hideNotice();
        this.cookieManager.createCookie( this.cookieName, true, 365 );
    }
}

let $cookieNotice = new CookieNotice();
$cookieNotice.init();
