// Product Class: Represent a Product
class Product {
    constructor(ProductID, ProductName, ProductPrice, quantity) {
      this.ProductID = ProductID;
      this.ProductName = ProductName;
      this.ProductPrice = ProductPrice;
      this.quantity = quantity;

    }
  }

  // UI Class: Handle UI Tasks
  class UI {
    static displayProducts() {
      const products = Cart.getProducts();

      let totalPrice = 0;

      products.forEach((product, index) => {
        UI.addProductToList(product,index)
      });
    }

    static addProductToList(product,index) {
      const list = document.querySelector('#product-list');

      const row = document.createElement('tr');

      let total = parseFloat(product.ProductPrice).toFixed(2) * parseInt(product.quantity);
      total = parseFloat(total).toFixed(2);

      row.innerHTML = `
      <td>${product.ProductName}</td>
      <td>${product.quantity}</td>
      <td>RM ${product.ProductPrice}</td>
      <td id="total">RM ${total}</td>
      <td style="display:none;">${product.ProductID}</td>
      <td><a href="#" class="btn btn-danger btn-sm delete">X</td>
      `;

      list.appendChild(row);
    }

    static deleteProduct(el) {
      if(el.classList.contains('delete')) {
        el.parentElement.parentElement.remove();
      }
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

    static addProduct(product) {
      const products = Cart.getProducts();

      products.push(product);

      localStorage.setItem('products', JSON.stringify(products));
    }

    static removeProduct(ProductID) {
      const products = Cart.getProducts();

      products.forEach((product, index) => {
        if(product.ProductID === ProductID) {
          products.splice(index, 1);
        }
      });

      localStorage.setItem('products', JSON.stringify(products));
    }
  }

  //  Event: Display Products
  document.addEventListener('DOMContentLoaded', UI.displayProducts);

  // Event Add a Product
  document.querySelector('#product-form').addEventListener('submit', (e) => {
    // prevent actual submit
    e.preventDefault();

    //get form values
    const ProductID = document.querySelector('#ProductID').value;
    const ProductName = document.querySelector('#ProductName').value;
    const ProductPrice = document.querySelector('#ProductPrice').value;
    const quantity = document.querySelector('#quantity').value;

    // Validate
    if(ProductID === '' || ProductName === '' || ProductPrice === '' || quantity === '') {
      // console.log('form fields not fill');
      // UI.showAlert('Please fill all field', 'danger');
    } else {
      // Instatiate product
      const product = new Product(ProductID, ProductName, ProductPrice, quantity);

      // Add product to UI
      UI.addProductToList(product);

      // Add product to cart
      Cart.addProduct(product);

    }
  });

  // Event Remove a Product
  document.querySelector('#product-list').addEventListener('click', (e) => {
    // console.log(e.target);

    // Remove product from UI
    UI.deleteProduct(e.target);

    // Remove product from cart
    Cart.removeProduct(e.target.parentElement.previousElementSibling.textContent)

  });
