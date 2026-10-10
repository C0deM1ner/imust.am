let spacer = 1; // 0.0625;
let spacers = {
    0: '0',
};
for (let i = 1; i <= 200; i++) {
    spacers[i] = `${i * spacer}px`
}

spacers['p-mob'] = '15px';
// spacers['col-mob'] = '8px';
spacers['col'] = '16px';
// spacers['col-big'] = '25px';
// spacers['col-fluid'] = '16px';

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class', // or 'media'
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        // "./node_modules/flowbite-react/**/*.js",
    ],
    theme: {
        screens: {
            xxs: {min: '375px'},  // => @media (min-width: 475px) { ... }
            xs: {min: '475px'},  // => @media (min-width: 475px) { ... }
            sm: {min: '640px'},  // => @media (min-width: 640px) { ... }
            md: {min: '768px'}, // => @media (min-width: 768px) { ... }
            lg: {min: '1024px'}, // => @media (min-width: 1024px) { ... }
            xl: {min: '1280px'}, // => @media (min-width: 1280px) { ... }
            '2xl': {min: '1720px'}, // => @media (min-width: 1536px) { ... }
            '3xl': {min: '1920px'}, // => @media (min-width: 1920px) { ... }
        },

        colors: {
            primary: '#8FABD4',
            primaryDark: '#6783AC',
            primaryLight: '#C1DAFF',
            white: '#ffffff',
            whiteAlfa: 'rgba(255,255,255,.5)',
            black: '#000',
            blackAlfa: 'rgba(0,0,0,.6)',
            blackAlfa40: 'rgba(0,0,0,.4)',
            textGray: '#303030',
            darkGray: '#707070',
            gray: '#DDDDDD',
            lightGray: '#EEEEEE',
            bg: '#EEEEEE',
            bgLight: '#F7F7F7',

            // Dark site theme
            ink: '#0D0F13',
            surface: '#15181E',
            surfaceRaised: '#1C2027',
            line: '#272B33',
            paper: '#ECEEF2',
            muted: '#9AA1AD',

            error: '#FF0000',
            success: '#1FB557',
            warning: '#FFD57D',
            disabled: '#DEDEE0',
            transparent: 'transparent',
        },

        fontSize: {
            'h1-mobile': ['22px', { lineHeight: '33px' }],
            'h1': ['64px', { lineHeight: 'normal' }],
            'h2-mobile': ['20px', { lineHeight: 'normal' }],
            'h2': ['56px', { lineHeight: 'normal' }],
            'h3-mobile': ['18px', { lineHeight: 'normal' }],
            'h3': ['40px', { lineHeight: 'normal' }],
            'h4-mobile': ['16px', { lineHeight: 'normal' }],
            'h4': ['24px', { lineHeight: 'normal' }],
            'h5-mobile': ['16px', { lineHeight: 'normal' }],
            'h5': ['20px', { lineHeight: 'normal' }],
            'h6-mobile': ['14px', { lineHeight: 'normal' }],
            'h6': ['18px', { lineHeight: 'normal' }],
            'pl-mobile': ['18px', { lineHeight: 'normal' }],
            'pl': ['20px', { lineHeight: 'normal' }],
            'pm-mobile': ['16px', { lineHeight: '24px' }],
            'pm': ['18px', { lineHeight: '26px' }],
            'p-mobile': ['14px', { lineHeight: 'normal' }],
            'p': ['16px', { lineHeight: 'normal' }],
            'ps-mobile': ['12px', { lineHeight: 'normal' }],
            'ps': ['14px', { lineHeight: 'normal' }],
            'subtitle-mobile': ['16px', { lineHeight: '24px' }],
            'subtitle': ['20px', { lineHeight: 'normal' }],
        },

        fontWeight: {
            thin: '100',
            extralight: '200',
            light: '300',
            normal: '400',
            medium: '500',
            semibold: '600',
            bold: '700',
            extrabold: '800',
            black: '900',
        },

        borderRadius: {
            unset: '0',
            0: '0',
            full: '100%',
            'dropdown': '16px',
            'input': '48px',
            'card': '20px',
            'card-small': '16px',
            'card-large': '32px',
            'btn': '30px',
            'btn-small': '12px',
            'pill': '56px',
            'header': '100px',
        },

        container: {
            /*screens: {
              sm: '600px',
              md: '728px',
              lg: '984px',
              xl: '1240px',
              '2xl': '1496px',
            },*/
            center: true,
            padding: {
                DEFAULT: spacers['p-mob'],
                sm: spacers['p-mob'],
                md: spacers['p-mob'],
                lg: spacers['col'],
                xl: spacers['col'],
                '2xl': spacers['col'],
                '3xl': spacers['col'],
            },
        },

        animatedSettings: {
            animatedSpeed: 1000,
            heartBeatSpeed: 500,
            hingeSpeed: 2000,
            bounceInSpeed: 750,
            bounceOutSpeed: 750,
            animationDelaySpeed: 500,
        },

        fontFamily: {
            sans: ['Google Sans', 'Noto Sans Armenian', 'sans-serif'],
            serif: ['Google Sans', 'Noto Sans Armenian', 'serif'],
        },

        spacing: spacers,

        space: ({theme}) => ({
            ...theme('spacing'),
        }),

        extend: {
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
            },
            transitionTimingFunction: {
                default: 'all 0.25s cubic-bezier(0.645,0.045,0.355,1)',
            },
            animation: {
                flashing: 'flashing 1s infinite alternate',
            },
            keyframes: {
                flashing: {
                    '0%': {backgroundColor: 'white'},
                    '50%, 100%': {backgroundColor: '#FFFFFF7F'},
                },
            },
            boxShadow: {
                'custom': '0px 14px 42px rgba(8, 15, 52, 0.06)',
                'dropdown': '0px 12px 24px 0px rgba(0, 0, 0, 0.16)',
            },
            zIndex: {
                'on-everyting': 999999,
                'dropdown': 99,
                '100': 100,
                '1': 1,
                '2': 2,
                '3': 3,
            },
            width: {
                '1/12': '8.333333%',
                '2/12': '16.666667%',
                '3/12': '25%',
                '4/12': '33.333333%',
                '5/12': '41.666667%',
                '6/12': '50%',
                '7/12': '58.333333%',
                '8/12': '66.666667%',
                '9/12': '75%',
                '10/12': '83.333333%',
                '11/12': '91.666667%',
                '12/12': '100%',
            },
            margin: {
                'push-0': '0%',
                'push-1': '8.333333%',
                'push-2': '16.666667%',
                'push-3': '25%',
                'push-4': '33.333333%',
                'push-5': '41.666667%',
                'push-6': '50%',
                'push-7': '58.333333%',
                'push-8': '66.666667%',
                'push-9': '75%',
                'push-10': '83.333333%',
                'push-11': '91.666667%',
            },
        }
    },
    plugins: [
        function ({addUtilities}) {
            addUtilities({
                '.text-ellipsis': {
                    display: '-webkit-box',
                    '-webkit-box-orient': 'vertical',
                    overflow: 'hidden',
                },
            });

            addUtilities({
                '.text-ellipsis-normal': {
                    'white-space': 'nowrap',
                    overflow: 'hidden',
                    'text-overflow': 'ellipsis',
                },
            });

            for (let i = 1; i <= 10; i++) {
                addUtilities({
                    [`.line-clamp-${i}`]: {
                        '-webkit-line-clamp': `${i}`,
                    },
                });
            }
        },
        function ({addComponents, addUtilities, theme}) {
            addComponents({
                '.container': {
                    maxWidth: '100%',
                    '@screen sm': {
                        maxWidth: '640px',
                    },
                    '@screen md': {
                        maxWidth: '768px',
                    },
                    '@screen lg': {
                        maxWidth: '1100px',
                    },
                    '@screen xl': {
                        maxWidth: '1280px',
                    },
                    '@screen 2xl': {
                        maxWidth: '1712px',
                    },
                    '@screen 3xl': {
                        maxWidth: '1712px',
                    },
                },
                '.container-fluid': {
                    width: '100%',
                    marginLeft: 'auto',
                    marginRight: 'auto',
                    paddingLeft: theme('spacing.col'),
                    paddingRight: theme('spacing.col'),
                    '@screen lg': {
                        paddingLeft: theme('spacing.col'),
                        paddingRight: theme('spacing.col'),
                    },
                    '&.no-gutters': {
                        paddingLeft: '0',
                        paddingRight: '0',
                    },
                },
                '.row': {
                    display: 'flex',
                    flexWrap: 'wrap',
                    flexDirection: 'row',
                    marginLeft: `-${theme('spacing.col')}`,
                    marginRight: `-${theme('spacing.col')}`,
                    '@screen lg': {
                        marginLeft: `-${theme('spacing.col')}`,
                        marginRight: `-${theme('spacing.col')}`,
                    },
                    '&.no-gutters': {
                        marginLeft: '0',
                        marginRight: '0',
                        '& > .col': {
                            paddingLeft: '0',
                            paddingRight: '0',
                        },
                    },
                },
                '.row-slider': {
                    display: 'flex',
                    flexWrap: 'nowrap',
                    flexDirection: 'row',
                    marginLeft: `-${theme('spacing.col')}`,
                    marginRight: `-${theme('spacing.col')}`,
                    overflowX: 'auto',
                    '@screen lg': {
                        marginLeft: `-${theme('spacing.col')}`,
                        marginRight: `-${theme('spacing.col')}`,
                    },
                    '&::-webkit-scrollbar': {
                        display: 'none',
                        width: '0',
                    },
                },
            });

            addUtilities(
                {
                    '.col': {
                        paddingLeft: theme('spacing.col'),
                        paddingRight: theme('spacing.col'),
                        '@screen lg': {
                            paddingLeft: theme('spacing.col'),
                            paddingRight: theme('spacing.col'),
                        },
                    },
                },
                ['responsive'],
            );

            for (let i = 1; i <= 12; i++) {
                addUtilities({
                    [`.col-${i}`]: {
                        width: theme(`width.${i}/12`),
                        paddingLeft: theme('spacing.col'),
                        paddingRight: theme('spacing.col'),
                        '@screen lg': {
                            paddingLeft: theme('spacing.col'),
                            paddingRight: theme('spacing.col'),
                        },
                    },
                    [`.push-${i}`]: {
                        marginLeft: theme(`margin.push-${i}`),
                    },
                });
            }
        },
        // require("flowbite/plugin"),
        // require('tailwindcss-animatecss'),
    ],
}
