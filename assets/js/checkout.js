
// UI Class: Handle UI Tasks
class UI {
  static displayProducts() {
    const products = Cart.getProducts();
  }

}


//  Store Class: Handles Storage
class Cart {
  static getProducts() {
    let products;
    if(localStorage.getItem('products') === null) {
      products = [];
    } else {
      products = JSON.parse(localStorage.getItem('products'));
    }

    return products;
  }
}

//  Event: Display Products
document.addEventListener('DOMContentLoaded', UI.displayProducts);

