const setCookie = (name, value, seconds, domain) => {
    let expires = "";
    if (seconds) {
        const date = new Date();
        date.setTime(date.getTime() + seconds * 1000);
        expires = `; expires=${date.toUTCString()}`;
    }
    let cookie = `${name}=${value}${expires}; path=/`;
    if (domain) {
        cookie += `; domain=${domain}`;
    }
    document.cookie = cookie;
};

const getCookie = name => {
    const nameEQ = `${name}=`;
    const ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
};

const removeCookie = name => {
    setCookie(name, "", -1, "");
};

export { setCookie, getCookie, removeCookie };
