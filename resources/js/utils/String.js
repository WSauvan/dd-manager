/**
 *
 * @param {string} str
 * @returns {*}
 */
export function kebabToCamel(str) {
  return str.replace(/(-\w)/g, (m) => m[1].toUpperCase());
}

/**
 *
 * @param {string} str
 * @returns {string}
 */
export function pascalToKebab(str) {
  return str.replace(/[\w]([A-Z])/g, (m) => m[0] + '-' + m[1]).toLowerCase();
}

/**
 *
 * @param {string} str
 * @returns {string}
 */
export function kebabToPascal(str) {
  return lcFirst(kebabToCamel(str));
}

/**
 *
 * @param {String} str
 * @returns {string}
 */
export function lcFirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}
