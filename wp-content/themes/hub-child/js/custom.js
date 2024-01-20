  document.addEventListener('DOMContentLoaded', function() {
    // L?y t?t c? c�c ph?n t? c� class l� "elementor-gallery-item__description" trong ph?n c� class "khoahoc352"
    var descriptions = document.querySelectorAll('.khoahoc352 .elementor-gallery-item__description');

    // Duy?t qua t?ng ph?n t? v� th�m button
    descriptions.forEach(function(description) {
      // T?o m?t button m?i
      var button = document.createElement('button');
      button.className = 'button46';
      button.innerHTML = 'T�m hi?u kh�a h?c';
      // Th�m button v�o cu?i m?i ph?n m� t?
      description.appendChild(button);
    });
  });
