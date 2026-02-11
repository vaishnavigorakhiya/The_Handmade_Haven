import { useEffect, useState } from 'react'



export default function Cart() {
  const [cart, setCart] = useState([])
  


  useEffect(() => {
    const saved = JSON.parse(localStorage.getItem('cart') || '[]')
    setCart(saved)
  }, [])

  const removeItem = (index) => {
    const updated = cart.filter((_, i) => i !== index)
    setCart(updated)
    localStorage.setItem('cart', JSON.stringify(updated))
  }

  const total = cart.reduce((sum, item) => sum + item.price, 0)


  return (
    <div className="page">
      <h1>Your Cart</h1>

      {cart.length === 0 ? (
        <p>No items yet.</p>
      ) : (
        <ul>
          {cart.map((item, index) => (
            <li key={`${item.id}-${index}`} style={{ marginBottom: 10 }}>
              <strong>{item.name}</strong> — ${(item.price / 100).toFixed(2)}
              {item.selected && (
                <div className="meta">
                  Color: {item.selected.color} | Size: {item.selected.size}
                  {item.selected.text && ` | Text: "${item.selected.text}"`}
                </div>
              )}
              <button onClick={() => removeItem(index)}>Remove</button>
            </li>
          ))}
        </ul>
      )}

      <h3>Total: ${(total / 100).toFixed(2)}</h3>
    </div>
  )

}