module.exports = {
    content: ['./templates/**/*.php'],
    theme: {
        extend: {
            fontFamily: {
                'BCSans': ['BCSans', 'sans-serif']
            },
            colors: {
                sagegreen: '#bfd5cf',
                sagedark: '#29735E',
                bluegreen: '#2F6173',
                darkblue: '#234075'
            },
            screens: {
                'short': { 'raw': '(max-height: 600px)' },
                // => @media (min-height: 600px) 
            },
        },
    },
    //darkMode: 'class',
    plugins: [],
}
