<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkHeaderMenuControl">
        <ul class="bk-header-menu">
            <xsl:for-each select="menu/items/item">
                <li>
                    <a href="{//siteurl}/{slug}"><xsl:value-of select="title" disable-output-escaping="yes"/></a>
                </li>
            </xsl:for-each>
        </ul>
    </xsl:template>
</xsl:stylesheet>
