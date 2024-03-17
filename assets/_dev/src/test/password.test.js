// passShowHide.test.js
const { describe, test, expect } = require("@jest/globals");
require('@testing-library/jest-dom');
const { TextEncoder, TextDecoder } = require('util');
global.TextEncoder = TextEncoder;
global.TextDecoder = TextDecoder;
const { JSDOM } = require("jsdom");
const fs = require("fs");
const path = require("path");

const passwordScript = fs.readFileSync(path.resolve(__dirname, "../js/password.js"), "utf8");
const dom = new JSDOM(`<html><body></body></html>`, { runScripts: "dangerously" });
dom.window.eval(passwordScript);
const PassShowHide = dom.window.PassShowHide;
dom.window.FileList.createImpl = jest.fn();

describe('PassShowHide function', () => {
    test('La visibilité du mot de passe devrait être modifiée correctement', () => {
        const parentElement = dom.window.document.createElement('div');
        const input = dom.window.document.createElement('input');
        input.type = 'password';
        const eye = dom.window.document.createElement('div');

        parentElement.appendChild(input);
        parentElement.appendChild(eye);

        PassShowHide(eye);

        expect(input.type).toBe('text');
        expect(eye.classList.contains('icon-fi-rr-eye')).toBe(true);
        expect(eye.classList.contains('icon-fi-rr-eye-crossed')).toBe(false);

        PassShowHide(eye);

        expect(input.type).toBe('password');
        expect(eye.classList.contains('icon-fi-rr-eye')).toBe(false);
        expect(eye.classList.contains('icon-fi-rr-eye-crossed')).toBe(true);
    });
});
