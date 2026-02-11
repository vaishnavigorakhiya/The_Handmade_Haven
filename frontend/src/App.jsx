import { BrowserRouter, Route, Routes } from 'react-router-dom'
import { useEffect, useState } from 'react'
import Header from './components/Header'
import Home from './pages/Home'
import Shop from './pages/Shop'
import Admin from './pages/Admin'
import Cart from './pages/Cart'
import ProductDetail from './pages/ProductDetail'
import Login from './pages/Login'
import Register from './pages/Register'

import './styles/App.css'

function App() {
  const [user, setUser] = useState(null)

  useEffect(() => {
    fetch('http://127.0.0.1:8000/api/me', { credentials: 'include' })
      .then((res) => (res.ok ? res.json() : null))
      .then((data) => setUser(data))
      .catch(() => setUser(null))
  }, [])

  return (
    <BrowserRouter>
      <div className="app-shell">
        {/* <Header user={user} /> */}
        <Header user={user} onUserUpdate={setUser} />

        <div className="container">
          <main className="site-main">
            <Routes>
              <Route path="/" element={<Home />} />
              <Route path="/shop" element={<Shop />} />
              <Route path="/cart" element={<Cart />} />
              <Route path="/admin" element={<Admin />} />
              <Route path="/product/:slug" element={<ProductDetail />} />
              <Route path="/login" element={<Login />} />
              <Route path="/register" element={<Register />} />
            </Routes>
          </main>

          <footer className="site-footer">
            © {new Date().getFullYear()} Handcrafted Store. All rights reserved.
          </footer>
        </div>
      </div>
    </BrowserRouter>
  )
}

export default App
