if (localStorage.getItem("color-theme") === "dark" || (!("color-theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
    document.documentElement.classList.add("dark");
} else {
    document.documentElement.classList.remove("dark");
}
function nav() {
    return {
        open: false,
        isDark: document.documentElement.classList.contains("dark"),
        toggleTheme() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            } else {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            }
        },
    };
}
