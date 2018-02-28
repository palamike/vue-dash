/**
 *
 * require element with meta[name="csrf-token"] in the document head.
 *
 * @param str
 * @returns Object
 */
export default function(str){
    let token = document.head.querySelector('meta[name="csrf-token"]');
    return JSON.parse(atob(str.replace(token.content.substr(5,15),'')));
}