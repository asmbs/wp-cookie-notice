/**
 * A simple class for managing cookies.
 */
export class CookieManager {

    /**
     * Creates a cookie.
     *
     * @param name The name of the cookie
     * @param value The value the cookie should receive
     * @param days How many days until the cookie should expire
     */
    createCookie( name, value, days ) {
        let expires = null;
        if ( days ) {
            let date = new Date();
            date.setTime( date.getTime() + ( days * 24 * 60 * 60 * 1000 ) );
            expires = '; expires=' + date.toGMTString();
        } else {
            expires = '';
        }
        document.cookie = name + '=' + value + expires + '; path=/';
    }

    /**
     * Reads a cookie.
     *
     * @param name The name of the cookie
     * @returns {*} The value of the cookie, or null if not found
     */
    readCookie( name ) {
        let nameEQ = name + '=';
        let ca = document.cookie.split( ';' );
        for ( let i = 0; i < ca.length; i++ ) {
            let c = ca[i];
            while ( ' ' == c.charAt( 0 ) ) {
                c = c.substring( 1, c.length );
            }
            if ( 0 == c.indexOf( nameEQ ) ) {
                return c.substring( nameEQ.length, c.length );
            }
        }
        return null;
    }

    /**
     * Erases a cookie.
     *
     * @param name The name of the cookie
     */
    eraseCookie( name ) {
        createCookie( name, '', -1 );
    }
}
