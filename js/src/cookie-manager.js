export class CookieManager {

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

    eraseCookie( name ) {
        createCookie( name, '', -1 );
    }
}
