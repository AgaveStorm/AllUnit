<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template name="BkHeaderSubmenu">
        <xsl:if test="items">
            <ul class="bk-header-submenu">
                <xsl:for-each select="items/item">
                    <li>
                        <a href="{//siteurl}/{slug}"><xsl:value-of select="title" disable-output-escaping="yes"/></a>
                        <xsl:call-template name="BkHeaderSubmenu"/>
                    </li>
                </xsl:for-each>
            </ul>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>
