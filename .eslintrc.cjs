module.exports = {
    "env": {
        "browser": true,
        "es2021": true
    },
    "extends": [
        "eslint:recommended",
        "plugin:react/recommended"
    ],
    "parserOptions": {
        "ecmaFeatures": {
            "jsx": true
        },
        "ecmaVersion": 12,
        "sourceType": "module"
    },
    "plugins": [
        "react"
    ],
    "settings": {
        "react": {
            "version": "detect" // Automatically detects the React version
        }
    },
    "rules": {
        "indent": ["error", 4],
        "linebreak-style": ["error", "unix"],
        "quotes": ["error", "single"],
        "semi": ["error", "always"],
        "no-unused-vars": ["warn"],
        "no-console": "warn",
        "object-curly-spacing": ["error", "always"],
        "space-before-function-paren": ["error", "always"],
        "react/jsx-closing-tag-location": "error",
        "react/jsx-quotes": ["error", "prefer-double"],
        "react/jsx-key": "error",
        "react/boolean-prop-naming": ["error", { "rule": "^(is|has)[A-Z]([A-Za-z0-9]?)+$" }],
        "react/no-deprecated": "warn",
        "react/no-did-mount-set-state": "error"
    }
};
